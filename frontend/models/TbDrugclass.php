<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_drugclass".
 *
 * @property integer $DrugClassID
 * @property string $DrugClass
 * @property string $DrugClassDesc
 */
class TbDrugclass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugclass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugClassID', 'DrugClass'], 'required','message'=>'*กรุณากรอกข้อมูล'],
            [['DrugClassID'], 'integer'],
            [['DrugClass'], 'string', 'max' => 50],
            [['DrugClassDesc'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugClassID' => 'Drug Class ID',
            'DrugClass' => 'Drug Class',
            'DrugClassDesc' => 'Drug Class Desc',
        ];
    }
}
