<?php

namespace SSupport\Module\Core\Utils;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Clone of {@link https://github.com/ElisDN/yii2-composite-form}.
 */
abstract class AbstractCompositeForm extends Model
{
    /**
     * @var Model[]|array[]
     */
    protected $_forms = [];

    /**
     * @return array of internal forms like ['meta', 'values']
     */
    abstract protected function internalForms();

    public function load($data, $formName = null)
    {
        $success = parent::load($data, $formName);
        foreach ($this->_forms as $name => $form) {
            if (\is_array($form)) {
                $success = Model::loadMultiple($form, $data, null === $formName ? null : $name) || $success;
            } else {
                $success = $form->load($data, '' !== $formName ? null : $name) || $success;
            }
        }

        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (null !== $attributeNames) {
            $parentNames = array_filter($attributeNames, 'is_string');
            $success = $parentNames ? parent::validate($parentNames, $clearErrors) : true;
        } else {
            $success = parent::validate(null, $clearErrors);
        }
        foreach ($this->_forms as $name => $form) {
            if (null === $attributeNames || \array_key_exists($name, $attributeNames) || \in_array($name, $attributeNames,
                    true)) {
                $innerNames = ArrayHelper::getValue($attributeNames, $name);
                if (\is_array($form)) {
                    $success = Model::validateMultiple($form, $innerNames) && $success;
                } else {
                    $success = $form->validate($innerNames, $clearErrors) && $success;
                }
            }
        }

        return $success;
    }

    public function hasErrors($attribute = null)
    {
        if (null !== $attribute && false === mb_strpos($attribute, '.')) {
            return parent::hasErrors($attribute);
        }
        if (parent::hasErrors($attribute)) {
            return true;
        }
        foreach ($this->_forms as $name => $form) {
            if (\is_array($form)) {
                foreach ($form as $i => $item) {
                    if (null === $attribute) {
                        if ($item->hasErrors()) {
                            return true;
                        }
                    } elseif (0 === mb_strpos($attribute, $name.'.'.$i.'.')) {
                        if ($item->hasErrors(mb_substr($attribute, mb_strlen($name.'.'.$i.'.')))) {
                            return true;
                        }
                    }
                }
            } else {
                if (null === $attribute) {
                    if ($form->hasErrors()) {
                        return true;
                    }
                } elseif (0 === mb_strpos($attribute, $name.'.')) {
                    if ($form->hasErrors(mb_substr($attribute, mb_strlen($name.'.')))) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function getErrors($attribute = null)
    {
        $result = parent::getErrors($attribute);
        foreach ($this->_forms as $name => $form) {
            if (\is_array($form)) {
                /** @var Model[] $form */
                foreach ($form as $i => $item) {
                    foreach ($item->getErrors() as $attr => $errors) {
                        /** @var array $errors */
                        $errorAttr = $name.'.'.$i.'.'.$attr;
                        if (null === $attribute) {
                            foreach ($errors as $error) {
                                $result[$errorAttr][] = $error;
                            }
                        } elseif ($errorAttr === $attribute) {
                            foreach ($errors as $error) {
                                $result[] = $error;
                            }
                        }
                    }
                }
            } else {
                foreach ($form->getErrors() as $attr => $errors) {
                    /** @var array $errors */
                    $errorAttr = $name.'.'.$attr;
                    if (null === $attribute) {
                        foreach ($errors as $error) {
                            $result[$errorAttr][] = $error;
                        }
                    } elseif ($errorAttr === $attribute) {
                        foreach ($errors as $error) {
                            $result[] = $error;
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function getFirstErrors()
    {
        $result = parent::getFirstErrors();
        foreach ($this->_forms as $name => $form) {
            if (\is_array($form)) {
                foreach ($form as $i => $item) {
                    foreach ($item->getFirstErrors() as $attr => $error) {
                        $result[$name.'.'.$i.'.'.$attr] = $error;
                    }
                }
            } else {
                foreach ($form->getFirstErrors() as $attr => $error) {
                    $result[$name.'.'.$attr] = $error;
                }
            }
        }

        return $result;
    }

    public function __get($name)
    {
        if (isset($this->_forms[$name])) {
            return $this->_forms[$name];
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (\in_array($name, $this->internalForms(), true)) {
            $this->_forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->_forms[$name]) || parent::__isset($name);
    }
}
