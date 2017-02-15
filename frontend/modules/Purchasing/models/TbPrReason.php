<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_pr_reason".
 *
 * @property integer $ids
 * @property string $PRReason
 * @property integer $PRTypeID
 */
class TbPrReason extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pr_reason';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRTypeID'], 'integer'],
            [['PRReason'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRReason' => 'Prreason',
            'PRTypeID' => 'Prtype ID',
        ];
    }
}
