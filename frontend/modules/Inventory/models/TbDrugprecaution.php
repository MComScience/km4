<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugprecaution".
 *
 * @property integer $ids
 * @property integer $TMTID_GPU
 * @property integer $DrugPrecaution_levelID
 * @property string $DrugPrecautionNote
 * @property string $DrugPrecaution_label
 * @property integer $ItemStatus
 *
 * @property TbDrugprecautionLevel $drugPrecautionLevel
 */
class TbDrugprecaution extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugprecaution';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'DrugPrecaution_levelID','DrugPrecautionNote','DrugPrecaution_label'], 'required'],
            [['TMTID_GPU', 'DrugPrecaution_levelID', 'ItemStatus'], 'integer'],
            [['DrugPrecautionNote', 'DrugPrecaution_label'], 'string', 'max' => 255],
            [['DrugPrecaution_levelID'], 'exist', 'skipOnError' => true, 'targetClass' => TbDrugprecautionLevel::className(), 'targetAttribute' => ['DrugPrecaution_levelID' => 'DrugPrecaution_levelID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'DrugPrecaution_levelID' => Yii::t('app', 'ระดับการเตือน'),
            'DrugPrecautionNote' => Yii::t('app', 'หมายเหตุ'),
            'DrugPrecaution_label' => Yii::t('app', 'ข้อความคำเตือนบนฉลากยา'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrugPrecautionLevel()
    {
        return $this->hasOne(TbDrugprecautionLevel::className(), ['DrugPrecaution_levelID' => 'DrugPrecaution_levelID']);
    }
    
    public function getDataonview()
    {
        return $this->hasOne(VwDrugprecaution::className(), ['ids' => 'ids']);
    }
}
