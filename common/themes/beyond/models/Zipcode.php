<?php

namespace dektrium\user\models;

use Yii;

/**
 * This is the model class for table "zipcode".
 *
 * @property integer $ZIPCODE_ID
 * @property string $DISTRICT_CODE
 * @property string $PROVINCE_ID
 * @property string $AMPHUR_ID
 * @property string $DISTRICT_ID
 * @property string $ZIPCODE
 */
class Zipcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zipcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DISTRICT_CODE', 'PROVINCE_ID', 'AMPHUR_ID', 'DISTRICT_ID', 'ZIPCODE'], 'required'],
            [['DISTRICT_CODE', 'PROVINCE_ID', 'AMPHUR_ID', 'DISTRICT_ID'], 'string', 'max' => 100],
            [['ZIPCODE'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ZIPCODE_ID' => 'Zipcode  ID',
            'DISTRICT_CODE' => 'District  Code',
            'PROVINCE_ID' => 'Province  ID',
            'AMPHUR_ID' => 'Amphur  ID',
            'DISTRICT_ID' => 'District  ID',
            'ZIPCODE' => 'Zipcode',
        ];
    }
}
