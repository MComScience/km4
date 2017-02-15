<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[LineBot]].
 *
 * @see LineBot
 */
class LineBotQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return LineBot[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LineBot|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
