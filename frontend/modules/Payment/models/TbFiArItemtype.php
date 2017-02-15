<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_ar_itemtype".
 *
 * @property string $ar_itemtype
 * @property string $ar_itemtype_decs
 */
class TbFiArItemtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_ar_itemtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ar_itemtype'], 'required'],
            [['ar_itemtype'], 'string', 'max' => 10],
            [['ar_itemtype_decs'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ar_itemtype' => 'Ar Itemtype',
            'ar_itemtype_decs' => 'Ar Itemtype Decs',
        ];
    }
}
