<?php

namespace app\modules\pharmacy\models;

/**
 * This is the ActiveQuery class for [[VwPtInfo]].
 *
 * @see VwPtInfo
 */
class VwPtInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return VwPtInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VwPtInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
