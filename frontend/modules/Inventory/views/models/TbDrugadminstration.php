<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugadminstration".
 *
 * @property integer $ids
 * @property integer $TMTID_GPU
 * @property integer $DrugRouteID
 * @property integer $DrugPrandialAdviceID
 * @property string $DrugRouteNote
 * @property integer $ItemStatus
 */
class TbDrugadminstration extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_drugadminstration';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['TMTID_GPU', 'DrugRouteID'], 'required'],
            [['TMTID_GPU', 'DrugRouteID', 'DrugPrandialAdviceID', 'ItemStatus'], 'integer'],
            [['DrugRouteNote'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญ'),
            'DrugRouteID' => Yii::t('app', 'วิธีการให้ยา'),
            'DrugPrandialAdviceID' => Yii::t('app', 'คำแนะนำการให้ยา'),
            'DrugRouteNote' => Yii::t('app', 'หมายเหตุ'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
        ];
    }

    public function getDataonview() {
        return $this->hasOne(VwDrugadminstration::className(), ['ids' => 'ids']);
    }

}
