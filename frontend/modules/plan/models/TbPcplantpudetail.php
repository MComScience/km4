<?php

namespace app\modules\plan\models;

use Yii;

/**
 * This is the model class for table "tb_pcplantpudetail".
 *
 * @property integer $ids
 * @property string $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property string $TPUExtendedCost
 * @property string $PCPlanItemEffectDate
 * @property integer $PCPlanItemStatusID
 * @property string $FNSTMT
 */
class TbPcplantpudetail extends \yii\db\ActiveRecord
{
    public $FSN_TMT;
    public $DispUnit;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pcplantpudetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCPlanNum', 'TMTID_TPU', 'TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost','PCPlanItemEffectDate'], 'required'],
            [['PCitemNum', 'TMTID_TPU', 'PCPlanItemStatusID'], 'integer'],
            //[['TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost'], 'number'],
            [['PCPlanItemEffectDate','FSN_TMT','DispUnit'], 'safe'],
            [['PCPlanNum'], 'string', 'max' => 100],
            [['FNSTMT'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'PCPlanNum' => Yii::t('app', 'Pcplan Num'),
            'PCitemNum' => Yii::t('app', 'Pcitem Num'),
            'TMTID_TPU' => Yii::t('app', 'Tmtid  Tpu'),
            'TPUUnitCost' => Yii::t('app', 'ราคา/หน่วย'),
            'TPUOrderQty' => Yii::t('app', 'จำนวน'),
            'TPUExtendedCost' => Yii::t('app', 'ราคารวม'),
            'PCPlanItemEffectDate' => Yii::t('app', 'วันที่เริ่มใช้'),
            'PCPlanItemStatusID' => Yii::t('app', 'Pcplan Item Status ID'),
            'FNSTMT' => Yii::t('app', 'Fnstmt'),
        ];
    }
}
