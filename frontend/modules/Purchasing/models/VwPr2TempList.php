<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_temp_list".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $POTypeID
 * @property string $POType
 * @property string $PRExpectDate
 * @property integer $PRStatusID
 * @property string $PRStatus
 * @property integer $ids_PR_selected
 */
class VwPr2TempList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_temp_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRTypeID', 'POTypeID', 'PRStatusID', 'ids_PR_selected'], 'integer'],
            [['PRNum', 'PRDate', 'PRTypeID', 'POTypeID', 'POType'], 'required'],
            [['PRDate', 'PRExpectDate'], 'safe'],
            [['PRNum', 'PRType', 'PRStatus'], 'string', 'max' => 50],
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
            'PRNum' => 'เลขที่ใบขอซื้อ',
            'PRDate' => 'วันที่',
            'PRTypeID' => 'Prtype ID',
            'PRType' => 'ประเภทใบขอซื้อ',
            'POTypeID' => 'Potype ID',
            'POType' => 'ประเภทการสั่งซื้อ',
            'PRExpectDate' => 'วันที่ต้องการสินค้า',
            'PRStatusID' => 'Prstatus ID',
            'PRStatus' => 'Prstatus',
            'ids_PR_selected' => 'Ids  Pr Selected',
        ];
    }
}
