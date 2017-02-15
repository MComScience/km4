<?php

namespace app\modules\Inventory\models;

/**
 * This is the ActiveQuery class for [[TbCreditItem]].
 *
 * @see TbCreditItem
 */
class TbCreditItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TbCreditItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TbCreditItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}