<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_druginteraction_level".
 *
 * @property integer $DDI_Effect_id
 * @property string $DDI_Effect_decs
 * @property integer $DDI_Serverity
 * @property integer $ItemStatus
 *
 * @property TbDruginteraction[] $tbDruginteractions
 * @property TbDruginteraction[] $tbDruginteractions0
 * @property TbDdiServerity $dDIServerity
 */
class TbDruginteractionLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_druginteraction_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DDI_Serverity', 'DDI_Effect_decs'], 'required'],
            [['DDI_Serverity', 'ItemStatus'], 'integer'],
            [['DDI_Effect_decs'], 'string', 'max' => 200],
            [['DDI_Serverity'], 'exist', 'skipOnError' => true, 'targetClass' => TbDdiServerity::className(), 'targetAttribute' => ['DDI_Serverity' => 'ids']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DDI_Effect_id' => Yii::t('app', 'Ddi  Effect ID'),
            'DDI_Effect_decs' => Yii::t('app', 'ผลกระทบ'),
            'DDI_Serverity' => Yii::t('app', 'ระดับผลกระทบ'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDruginteractions()
    {
        return $this->hasMany(TbDruginteraction::className(), ['DDI_Effect_id' => 'DDI_Effect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDruginteractions0()
    {
        return $this->hasMany(TbDruginteraction::className(), ['DDI_Effect_id' => 'DDI_Effect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDDIServerity()
    {
        return $this->hasOne(TbDdiServerity::className(), ['ids' => 'DDI_Serverity']);
    }
}
