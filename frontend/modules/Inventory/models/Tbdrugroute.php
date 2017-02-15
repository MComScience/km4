<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugroute".
 *
 * @property integer $DrugRouteID
 * @property string $DrugRouteName
 * @property string $DrugRouteShotName
 * @property string $DrugRouteDesc
 * @property integer $ItemStatus
 *
 * @property TbDrugadminstration[] $tbDrugadminstrations
 */
class Tbdrugroute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugroute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugRouteID'], 'required'],
            [['DrugRouteID', 'ItemStatus'], 'integer'],
            [['DrugRouteName', 'DrugRouteShotName', 'DrugRouteDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugRouteID' => Yii::t('app', 'Drug Route ID'),
            'DrugRouteName' => Yii::t('app', 'Drug Route Name'),
            'DrugRouteShotName' => Yii::t('app', 'Drug Route Shot Name'),
            'DrugRouteDesc' => Yii::t('app', 'Drug Route Desc'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDrugadminstrations()
    {
        return $this->hasMany(TbDrugadminstration::className(), ['DrugRouteID' => 'DrugRouteID']);
    }
}
