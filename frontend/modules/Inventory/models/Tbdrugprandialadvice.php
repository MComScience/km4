<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugprandialadvice".
 *
 * @property integer $DrugPrandialAdviceID
 * @property integer $DrugRouteID
 * @property string $DrugPrandialAdviceDesc
 * @property integer $ItemStatus
 *
 * @property TbDrugadminstration[] $tbDrugadminstrations
 */
class Tbdrugprandialadvice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugprandialadvice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugRouteID', 'ItemStatus'], 'integer'],
            [['DrugPrandialAdviceDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugPrandialAdviceID' => Yii::t('app', 'Drug Prandial Advice ID'),
            'DrugRouteID' => Yii::t('app', 'Drug Route ID'),
            'DrugPrandialAdviceDesc' => Yii::t('app', 'Drug Prandial Advice Desc'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDrugadminstrations()
    {
        return $this->hasMany(TbDrugadminstration::className(), ['DrugPrandialAdviceID' => 'DrugPrandialAdviceID']);
    }
}
