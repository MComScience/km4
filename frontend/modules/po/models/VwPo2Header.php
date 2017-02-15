<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_po2_header".
 *
 * @property integer $POID
 * @property string $PONum
 * @property string $PODate
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $POTypeID
 * @property string $POType
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $POStatus
 * @property string $POStatusDes
 * @property string $VendorID
 * @property string $VenderName
 * @property string $MemuName
 */
class VwPo2Header extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'vw_po2_header';
    }

    public static function primaryKey() {
        return array(
            'POID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['POID', 'POTypeID', 'PRTypeID', 'POStatus'], 'integer'],
                [['PODate', 'PRDate'], 'safe'],
                [['PRNum', 'PRDate', 'POType', 'POStatusDes'], 'required'],
                [['PONum', 'PRNum', 'PRType', 'POStatusDes'], 'string', 'max' => 50],
                [['POType'], 'string', 'max' => 150],
                [['VendorID'], 'string', 'max' => 13],
                [['VenderName', 'MemuName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'POID' => Yii::t('app', 'Poid'),
            'PONum' => Yii::t('app', 'Ponum'),
            'PODate' => Yii::t('app', 'Podate'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PRDate' => Yii::t('app', 'Prdate'),
            'POTypeID' => Yii::t('app', 'Potype ID'),
            'POType' => Yii::t('app', 'Potype'),
            'PRTypeID' => Yii::t('app', 'Prtype ID'),
            'PRType' => Yii::t('app', 'Prtype'),
            'POStatus' => Yii::t('app', 'Postatus'),
            'POStatusDes' => Yii::t('app', 'Postatus Des'),
            'VendorID' => Yii::t('app', 'Vendor ID'),
            'VenderName' => Yii::t('app', 'Vender Name'),
            'MemuName' => Yii::t('app', 'Memu Name'),
        ];
    }

}
