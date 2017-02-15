<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_list_for_po2".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $POTypeID
 * @property string $POType
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $PRStatusID
 * @property integer $PRExpectDate
 */
class VwPr2ListForPo2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_list_for_po2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'POTypeID', 'PRTypeID', 'PRStatusID', 'PRExpectDate'], 'integer'],
            [['PRNum', 'PRDate', 'POTypeID', 'PRTypeID'], 'required'],
            [['PRDate'], 'safe'],
            [['PRNum', 'PRType'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'PRNum' => 'Prnum',
            'PRDate' => 'Prdate',
            'POTypeID' => 'Potype ID',
            'POType' => 'Potype',
            'PRTypeID' => 'Prtype ID',
            'PRType' => 'Prtype',
            'PRStatusID' => 'Prstatus ID',
            'PRExpectDate' => 'Prexpect Date',
        ];
    }
}
