<?php

namespace app\modules\chemo\models\std;

use Yii;

/**
 * This is the model class for table "tb_scl".
 *
 * @property string $pt_maininscl_id
 * @property string $pt_maininscl_decs
 * @property string $pt_maininscl_idnew
 * @property string $pt_maininscl_decsnew
 * @property string $medical_right_id_defualt
 * @property integer $credit_group_id
 */
class TbScl extends \yii\db\ActiveRecord
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
            [['credit_group_id'], 'integer'],
            [['pt_maininscl_id'], 'string', 'max' => 20],
            [['pt_maininscl_decs', 'pt_maininscl_decsnew'], 'string', 'max' => 50],
            [['pt_maininscl_idnew'], 'string', 'max' => 4],
            [['medical_right_id_defualt'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_maininscl_id' => 'Pt Maininscl ID',
            'pt_maininscl_decs' => 'Pt Maininscl Decs',
            'pt_maininscl_idnew' => 'Pt Maininscl Idnew',
            'pt_maininscl_decsnew' => 'Pt Maininscl Decsnew',
            'medical_right_id_defualt' => 'Medical Right Id Defualt',
            'credit_group_id' => 'Credit Group ID',
        ];
    }
}
