<?php

namespace SSupport\Module\Core\Gateway\Repository;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\SSupport\Module\Core\Entity\Attachment]].
 *
 * @see \SSupport\Module\Core\Entity\Attachment
 */
class AttachmentRepository extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     *
     * @return \SSupport\Module\Core\Entity\Attachment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return \SSupport\Module\Core\Entity\Attachment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
