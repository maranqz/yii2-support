<?php

namespace SSupport\Module\Core\Utils;

trait ModelGetRulesTrait
{
    public function getModelRulesByFields($class, array $neededFields)
    {
        $rules = $this->make($class)->rules();

        $rulesByFiled = $this->generateRulesByField($rules, $neededFields);

        return $this->getResultRules($rules, $neededFields, $rulesByFiled);
    }

    protected function generateRulesByField($rules, $neededFields)
    {
        $neededFieldsTable = array_fill_keys($neededFields, true);
        $rulesByFiled = [];
        foreach ($rules as $index => &$rule) {
            $fields = $rule[0];
            $rule[0] = [];
            foreach ($fields as $field) {
                if (empty($neededFieldsTable[$field])) {
                    continue;
                }

                if (empty($rulesByFiled[$field])) {
                    $rulesByFiled[$field] = [];
                }
                $rulesByFiled[$field][] = $index;
            }
        }

        return $rulesByFiled;
    }

    protected function getResultRules($rules, $neededFields, $rulesByFiled)
    {
        $resultRule = [];
        foreach ($neededFields as $neededField) {
            foreach ($rulesByFiled[$neededField] as $ruleIndexes) {
                if (empty($resultRule[$ruleIndexes])) {
                    $resultRule[$ruleIndexes] = $rules[$ruleIndexes];
                }

                $fields = &$resultRule[$ruleIndexes][0];
                $fields[] = $neededField;
            }
        }

        return $resultRule;
    }
}
