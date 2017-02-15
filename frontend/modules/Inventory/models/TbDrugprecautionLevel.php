<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugprecaution_level".
 *
 * @property integer $DrugPrecaution_levelID
 * @property string $DrugPrecaution_levelDesc
 * @property integer $ItemStatus
 *
 * @property TbDrugprecaution[] $tbDrugprecautions
 */
class TbDrugprecautionLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugprecaution_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugPrecaution_levelID'], 'required'],
            [['DrugPrecaution_levelID', 'ItemStatus'], 'integer'],
            [['DrugPrecaution_levelDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugPrecaution_levelID' => Yii::t('app', 'Drug Precaution Level ID'),
            'DrugPrecaution_levelDesc' => Yii::t('app', 'Drug Precaution Level Desc'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDrugprecautions()
    {
        return $this->hasMany(TbDrugprecaution::className(), ['DrugPrecaution_level' => 'DrugPrecaution_levelID']);
    }
}
