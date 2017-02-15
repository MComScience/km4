<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_ised".
 *
 * @property integer $ISEDID
 * @property string $ISED
 * @property string $ISEDDesc
 */
class TbIsed extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_ised';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ISED', 'ISEDDesc'], 'required','message'=>'*กรุณากรอกข้อมูล'],
            [['ISED'], 'string', 'max' => 45],
            [['ISEDDesc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ISEDID' => 'Isedid',
            'ISED' => 'Ised',
            'ISEDDesc' => 'Iseddesc',
        ];
    }

}
