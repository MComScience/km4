<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_contunit".
 *
 * @property integer $ContUnitID
 * @property string $ContUnit
 * @property string $ContUnitDesc
 */
class TbContunit extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_contunit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ContUnit'], 'required','message'=>'*กรุณากรอกข้อมูล'],
            [['ContUnit'], 'string', 'max' => 45],
            [['ContUnitDesc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ContUnitID' => 'Cont Unit ID',
            'ContUnit' => 'Cont Unit',
            'ContUnitDesc' => 'Cont Unit Desc',
        ];
    }
}
