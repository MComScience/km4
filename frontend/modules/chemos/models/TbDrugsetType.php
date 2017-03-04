<?php

namespace app\modules\chemos\models;

use Yii;

/**
 * This is the model class for table "tb_drugset_type".
 *
 * @property string $drugset_type
 * @property string $drugset_type_decs
 */
class TbDrugsetType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_drugset_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drugset_type_id'], 'required'],
            [['drugset_type_id'], 'string', 'max' => 10],
            [['drugset_type_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drugset_type_id' => 'Drugset Type',
            'drugset_type_decs' => 'Drugset Type Decs',
        ];
    }
}
