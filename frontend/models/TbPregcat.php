<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pregcat".
 *
 * @property integer $PregCatID
 * @property string $PregCat
 * @property string $PregCatDecs
 */
class TbPregcat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pregcat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PregCat'], 'required','message'=>'*กรุณากรอกข้อมูล'],
            [['PregCat'], 'string', 'max' => 45],
            [['PregCatDecs'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PregCatID' => 'Preg Cat ID',
            'PregCat' => 'Preg Cat',
            'PregCatDecs' => 'Preg Cat Decs',
        ];
    }
}
