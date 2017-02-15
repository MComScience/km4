<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_scl".
 *
 * @property string $pt_maininscl_id
 * @property string $pt_maininscl_decs
 * @property string $pt_maininscl_idnew
 * @property string $pt_maininscl_decsnew
 */
class Tbscl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_scl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_maininscl_id'], 'required'],
            [['pt_maininscl_id'], 'string', 'max' => 20],
            [['pt_maininscl_decs', 'pt_maininscl_decsnew'], 'string', 'max' => 50],
            [['pt_maininscl_idnew'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_maininscl_id' => Yii::t('app', 'รหัสสิทธิการรักษา'),
            'pt_maininscl_decs' => Yii::t('app', 'สิทธิการรักษา'),
            'pt_maininscl_idnew' => Yii::t('app', 'Pt Maininscl Idnew'),
            'pt_maininscl_decsnew' => Yii::t('app', 'Pt Maininscl Decsnew'),
        ];
    }
}
