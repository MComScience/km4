<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_druggroup".
 *
 * @property integer $druggroupID
 * @property string $druggroup
 * @property string $druggroupdesc
 */
class TbDruggroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_druggroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['druggroup'], 'required','message'=>'*กรุณากรอกข้อมูล'],
            [['druggroup'], 'string', 'max' => 50],
            [['druggroupdesc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'druggroupID' => 'Druggroup ID',
            'druggroup' => 'Druggroup',
            'druggroupdesc' => 'Druggroupdesc',
        ];
    }
}
