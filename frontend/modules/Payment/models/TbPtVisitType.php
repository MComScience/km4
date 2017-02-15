<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_pt_visit_type".
 *
 * @property string $pt_visit_type_code
 * @property string $pt_visit_type_desc
 */
class TbPtVisitType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_visit_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_visit_type_code'], 'required'],
            [['pt_visit_type_code'], 'string', 'max' => 2],
            [['pt_visit_type_desc'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_visit_type_code' => 'Pt Visit Type Code',
            'pt_visit_type_desc' => 'Pt Visit Type Desc',
        ];
    }
}
