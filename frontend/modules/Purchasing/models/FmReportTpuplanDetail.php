<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "fm_report_tpuplan_detail".
 *
 * @property string $PCPlanNum
 * @property integer $PCitemNum
 * @property integer $TMTID_TPU
 * @property string $ItemName
 * @property string $itemContVal
 * @property string $ContUnit
 * @property string $DispUnit
 * @property string $TPUUnitCost
 * @property string $TPUOrderQty
 * @property string $TPUOrderQty2
 * @property double $TPUExtendedCost
 * @property string $TPUExtendedCost2
 * @property integer $ItemID
 */
class FmReportTpuplanDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fm_report_tpuplan_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PCitemNum', 'TMTID_TPU', 'ItemID'], 'integer'],
            [['ContUnit', 'DispUnit', 'ItemID'], 'required'],
            [['TPUUnitCost', 'TPUOrderQty', 'TPUExtendedCost'], 'number'],
            [['PCPlanNum'], 'string', 'max' => 20],
            [['ItemName'], 'string', 'max' => 150],
            [['itemContVal'], 'string', 'max' => 50],
            [['ContUnit', 'DispUnit'], 'string', 'max' => 45],
            [['TPUOrderQty2'], 'string', 'max' => 61],
            [['TPUExtendedCost2'], 'string', 'max' => 62],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PCPlanNum' => 'Pcplan Num',
            'PCitemNum' => 'Pcitem Num',
            'TMTID_TPU' => 'Tmtid  Tpu',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'itemContVal' => 'Item Cont Val',
            'ContUnit' => 'หน่วยของบรรจุภัณฑ์',
            'DispUnit' => 'Disp Unit',
            'TPUUnitCost' => 'Tpuunit Cost',
            'TPUOrderQty' => 'Tpuorder Qty',
            'TPUOrderQty2' => 'Tpuorder Qty2',
            'TPUExtendedCost' => 'Tpuextended Cost',
            'TPUExtendedCost2' => 'Tpuextended Cost2',
            'ItemID' => 'รหัสที่ รพ.กำหนด',
        ];
    }
}
