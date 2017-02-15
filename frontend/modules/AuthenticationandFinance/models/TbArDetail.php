<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_ar_detail".
 *
 * @property string $ar_maincode
 * @property string $ar_name
 * @property string $ar_deptcode
 * @property string $ar_typecode
 * @property string $ar_areacode
 * @property string $ar_address
 * @property string $ar_province
 * @property string $ar_amphur
 * @property string $ar_tumbol
 * @property string $ar_postcode
 * @property string $ar_tel
 * @property string $ar_fax
 * @property string $ar_service_level
 * @property string $ar_service_type
 * @property string $ar_code5
 * @property string $ar_status
 */
class TbArDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ar_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_maincode'], 'required'],
            [['ar_maincode'], 'string', 'max' => 9],
            [['ar_name', 'ar_address'], 'string', 'max' => 255],
            [['ar_deptcode', 'ar_postcode'], 'string', 'max' => 5],
            [['ar_typecode', 'ar_status'], 'string', 'max' => 2],
            [['ar_areacode'], 'string', 'max' => 8],
            [['ar_province', 'ar_amphur', 'ar_tumbol', 'ar_tel', 'ar_fax', 'ar_service_level', 'ar_service_type', 'ar_code5'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_maincode' => 'รหัสหน่วย',
            'ar_name' => 'ชื่อหน่วย',
            'ar_deptcode' => 'รหัสกระทรวง กรม		',
            'ar_typecode' => 'รหัสประเภทหน่วยงาน',
            'ar_areacode' => 'รหัสพื้นที่',
            'ar_address' => 'Ar Address',
            'ar_province' => 'จังหวัด',
            'ar_amphur' => 'อำเภอ',
            'ar_tumbol' => 'ตำบล',
            'ar_postcode' => 'Ar Postcode',
            'ar_tel' => 'โทรศัพท์',
            'ar_fax' => 'โทรสาร',
            'ar_service_level' => 'ระดับการบริการ',
            'ar_service_type' => 'ประเภทบริการ	',
            'ar_code5' => 'รหัสเดิม',
            'ar_status' => 'สถานะการเปิดบริการ',
        ];
    }
}
