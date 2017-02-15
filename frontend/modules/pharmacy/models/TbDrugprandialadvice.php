<?php

namespace app\modules\pharmacy\models;

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
class TbDrugprandialadvice extends \yii\db\ActiveRecord
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
            'DrugPrandialAdviceID' => 'Drug Prandial Advice ID',
            'DrugRouteID' => 'Drug Route ID',
            'DrugPrandialAdviceDesc' => 'Drug Prandial Advice Desc',
            'ItemStatus' => 'Item Status',
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
