<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_drugsubclass".
 *
 * @property integer $DrugSubClassID
 * @property integer $DrugClassID
 * @property string $DrugSubClass
 * @property string $DrugSubClassDesc
 */
class TbDrugsubclass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugsubclass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DrugSubClassID'], 'required'],
            [['DrugSubClassID', 'DrugClassID'], 'integer'],
            [['DrugSubClass'], 'string', 'max' => 50],
            [['DrugSubClassDesc'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DrugSubClassID' => Yii::t('app', 'Drug Sub Class ID'),
            'DrugClassID' => Yii::t('app', 'Drug Class ID'),
            'DrugSubClass' => Yii::t('app', 'Drug Sub Class'),
            'DrugSubClassDesc' => Yii::t('app', 'Drug Sub Class Desc'),
        ];
    }
}
