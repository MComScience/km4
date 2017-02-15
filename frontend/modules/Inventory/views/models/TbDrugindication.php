<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugindication".
 *
 * @property integer $ids
 * @property integer $TMTID_GPU
 * @property string $DrugIndicationDesc
 * @property string $DrugIndicationDesc_label
 * @property integer $ItemStatus
 */
class TbDrugindication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugindication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugIndicationDesc', 'DrugIndicationDesc_label','TMTID_GPU'], 'required'],
            [['TMTID_GPU', 'ItemStatus'], 'integer'],
            [['DrugIndicationDesc', 'DrugIndicationDesc_label'], 'string', 'max' => 255],
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
            'DrugIndicationDesc' => Yii::t('app', 'สรรพคุณทางยา'),
            'DrugIndicationDesc_label' => Yii::t('app', 'ข้อความสรรพคุณทางยาบนฉลากยา'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }
    
//     public function getDataonview() {
//        return $this->hasOne(VwDrugindication::className(), ['ids' => 'ids']);
//    }
}
