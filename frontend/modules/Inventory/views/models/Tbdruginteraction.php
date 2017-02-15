<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_druginteraction".
 *
 * @property integer $DDI_id
 * @property integer $Drug1
 * @property integer $Drug2
 * @property integer $ItemStatus
 * @property integer $CreateBy
 * @property string $CreateDate
 * @property integer $DDI_Effect_id
 *
 * @property TbDruginteractionLevel $dDIEffect
 * @property TbDruginteractionLevel $dDIEffect0
 */
class Tbdruginteraction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_druginteraction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Drug1', 'Drug2', 'ItemStatus', 'CreateBy', 'DDI_Effect_id'], 'integer'],
            [['CreateDate'], 'safe'],
            [['DDI_Effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbDruginteractionLevel::className(), 'targetAttribute' => ['DDI_Effect_id' => 'DDI_Effect_id']],
            [['DDI_Effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => TbDruginteractionLevel::className(), 'targetAttribute' => ['DDI_Effect_id' => 'DDI_Effect_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DDI_id' => Yii::t('app', 'เลขที่DDI'),
            'Drug1' => Yii::t('app', 'TMTID_VTM1'),
            'Drug2' => Yii::t('app', 'TMTID_VTM2'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
            'CreateBy' => Yii::t('app', 'Create By'),
            'CreateDate' => Yii::t('app', 'Create Date'),
            'DDI_Effect_id' => Yii::t('app', 'เลขที่ผลกระทบ'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDDIEffect()
    {
        return $this->hasOne(TbDruginteractionLevel::className(), ['DDI_Effect_id' => 'DDI_Effect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDDIEffect0()
    {
        return $this->hasOne(TbDruginteractionLevel::className(), ['DDI_Effect_id' => 'DDI_Effect_id']);
    }
}
