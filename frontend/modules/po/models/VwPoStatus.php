<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_po_status".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $PRTypeID
 * @property string $POType
 * @property string $PRStatus
 * @property string $POID
 * @property string $PODate
 * @property string $POStatus
 * @property string $Vender
 * @property string $Menu_Vendor
 * @property string $GRStatus
 * @property string $GRDate
 */
class VwPoStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRNum', 'PRDate', 'PRTypeID'], 'required'],
            [['PRID', 'PRTypeID', 'POID'], 'integer'],
            [['PRDate', 'PODate', 'GRDate'], 'safe'],
            [['PRNum', 'PRStatus', 'POStatus', 'GRStatus'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
            [['Vender', 'Menu_Vendor'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => Yii::t('app', 'Prid'),
            'PRNum' => Yii::t('app', 'Prnum'),
            'PRDate' => Yii::t('app', 'Prdate'),
            'PRTypeID' => Yii::t('app', 'Prtype ID'),
            'POType' => Yii::t('app', 'Potype'),
            'PRStatus' => Yii::t('app', 'Prstatus'),
            'POID' => Yii::t('app', 'Poid'),
            'PODate' => Yii::t('app', 'Podate'),
            'POStatus' => Yii::t('app', 'Postatus'),
            'Vender' => Yii::t('app', 'Vender'),
            'Menu_Vendor' => Yii::t('app', 'Menu  Vendor'),
            'GRStatus' => Yii::t('app', 'Grstatus'),
            'GRDate' => Yii::t('app', 'Grdate'),
        ];
    }
}
