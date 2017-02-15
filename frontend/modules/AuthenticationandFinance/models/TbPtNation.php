<?php

namespace app\modules\AuthenticationandFinance\models;

use Yii;

/**
 * This is the model class for table "tb_pt_nation".
 *
 * @property string $pt_nation_id
 * @property string $pt_nation_decs
 */
class TbPtNation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_nation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_nation_id'], 'required'],
            [['pt_nation_id'], 'string', 'max' => 4],
            [['pt_nation_decs'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_nation_id' => Yii::t('app', 'Pt Nation ID'),
            'pt_nation_decs' => Yii::t('app', 'Pt Nation Decs'),
        ];
    }
}
