<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stklevelinfo".
 *
 * @property integer $ItemID
 * @property integer $StkID
 * @property string $StkName
 * @property string $ItemReorderLevel
 * @property string $ItemTargetLevel
 * @property integer $ItemStatus
 * @property string $DispUnit
 */
class VwStklevelinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stklevelinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'StkID'], 'required'],
            [['ItemID', 'StkID', 'ItemStatus'], 'integer'],
            [['ItemReorderLevel', 'ItemTargetLevel'], 'number'],
            [['StkName'], 'string', 'max' => 50],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'Item ID'),
            'StkID' => Yii::t('app', 'Stk ID'),
            'StkName' => Yii::t('app', 'Stk Name'),
            'ItemReorderLevel' => Yii::t('app', 'Item Reorder Level'),
            'ItemTargetLevel' => Yii::t('app', 'Item Target Level'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
        ];
    }
}
