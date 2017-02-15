<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_stk_yearcut".
 *
 * @property integer $ItemID
 * @property integer $ItemCatID
 * @property string $ItemName
 * @property string $DispUnit
 * @property string $YEAR
 * @property string $M01
 * @property string $M02
 * @property string $M03
 * @property string $M04
 * @property string $M05
 * @property string $M06
 * @property string $M07
 * @property string $M08
 * @property string $M09
 * @property string $M10
 * @property string $M11
 * @property string $M12
 * @property string $MCum
 */
class VwStkYearcut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_stk_yearcut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'ItemCatID'], 'required'],
            [['ItemID', 'ItemCatID'], 'integer'],
            [['YEAR', 'M01', 'M02', 'M03', 'M04', 'M05', 'M06', 'M07', 'M08', 'M09', 'M10', 'M11', 'M12', 'MCum'], 'number'],
            [['ItemName'], 'string', 'max' => 150],
            [['DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'รหัสที่ รพ.กำหนด',
            'ItemCatID' => 'ประเภทยาและเวชภัณฑ์',
            'ItemName' => 'ชื่อสินค้า หรือ FNS',
            'DispUnit' => 'Disp Unit',
            'YEAR' => 'Year',
            'M01' => 'M01',
            'M02' => 'M02',
            'M03' => 'M03',
            'M04' => 'M04',
            'M05' => 'M05',
            'M06' => 'M06',
            'M07' => 'M07',
            'M08' => 'M08',
            'M09' => 'M09',
            'M10' => 'M10',
            'M11' => 'M11',
            'M12' => 'M12',
            'MCum' => 'Mcum',
        ];
    }
}
