<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_pt_titlename".
 *
 * @property string $pt_titlename_id
 * @property string $pt_titlename
 * @property integer $pt_sex_id
 */
class TbPtTitlename extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_titlename';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_titlename_id'], 'required'],
            [['pt_sex_id'], 'integer'],
            [['pt_titlename_id'], 'string', 'max' => 11],
            [['pt_titlename'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_titlename_id' => 'Pt Titlename ID',
            'pt_titlename' => 'Pt Titlename',
            'pt_sex_id' => 'Pt Sex ID',
        ];
    }
}
