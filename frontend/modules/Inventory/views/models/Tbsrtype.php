<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_srtype".
 *
 * @property integer $SRTypeID
 * @property string $SRType
 */
class Tbsrtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_srtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SRType'], 'required'],
            [['SRType'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRTypeID' => 'Srtype ID',
            'SRType' => 'Srtype',
        ];
    }
}
