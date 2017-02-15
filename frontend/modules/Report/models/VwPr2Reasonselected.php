<?php

namespace app\modules\Report\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_reasonselected".
 *
 * @property integer $ids
 * @property integer $PRID
 * @property integer $PRTypeID
 * @property string $PRReason
 */
class VwPr2Reasonselected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_reasonselected';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ids', 'PRID', 'PRTypeID'], 'integer'],
            [['PRReason'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRID' => 'Prid',
            'PRTypeID' => 'Prtype ID',
            'PRReason' => 'Prreason',
        ];
    }
}
