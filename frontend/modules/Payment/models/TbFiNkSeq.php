<?php

namespace app\modules\Payment\models;

use Yii;

/**
 * This is the model class for table "tb_fi_nk_seq".
 *
 * @property integer $nk_seq_id
 * @property string $seq
 * @property string $h_main
 * @property string $visit_time
 * @property string $hn_id_no
 * @property integer $pt_right
 * @property string $hn_no
 * @property string $fullname
 * @property string $sex
 * @property integer $age
 * @property string $diag10
 * @property string $diag9
 * @property string $doc_code
 * @property string $p_lab
 * @property string $p_xray
 * @property string $p_us
 * @property string $p_tm
 * @property string $p_ot
 * @property string $p_cl
 * @property string $p_sent
 * @property string $p_bb
 * @property string $p_chemo
 * @property string $p_rt
 * @property string $p_or
 * @property string $p_drug
 * @property string $notpay
 * @property integer $import_by
 * @property string $import_date
 */
class TbFiNkSeq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_fi_nk_seq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            [['visit_time', 'import_date'], 'safe'],
            [['pt_right', 'age', 'import_by'], 'integer'],
            [['p_lab', 'p_xray', 'p_us', 'p_tm', 'p_ot', 'p_cl', 'p_sent', 'p_bb', 'p_chemo', 'p_rt', 'p_or', 'p_drug', 'notpay'], 'number'],
            [['seq', 'sex', 'doc_code'], 'string', 'max' => 20],
            [['h_main', 'fullname', 'diag10', 'diag9'], 'string', 'max' => 255],
            [['hn_id_no'], 'string', 'max' => 13],
            [['hn_no'], 'string', 'max' => 50],
       */ ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nk_seq_id' => 'Nk Seq ID',
            'seq' => 'Seq',
            'h_main' => 'H Main',
            'visit_time' => 'Visit Time',
            'hn_id_no' => 'Hn Id No',
            'pt_right' => 'Pt Rigth',
            'hn_no' => 'Hn No',
            'fullname' => 'Fullname',
            'sex' => 'Sex',
            'age' => 'Age',
            'diag10' => 'Diag10',
            'diag9' => 'Diag9',
            'doc_code' => 'Doc Code',
            'p_lab' => 'P Lab',
            'p_xray' => 'P Xray',
            'p_us' => 'P Us',
            'p_tm' => 'P Tm',
            'p_ot' => 'P Ot',
            'p_cl' => 'P Cl',
            'p_sent' => 'P Sent',
            'p_bb' => 'P Bb',
            'p_chemo' => 'P Chemo',
            'p_rt' => 'P Rt',
            'p_or' => 'P Or',
            'p_drug' => 'P Drug',
            'notpay' => 'Notpay',
            'import_by' => 'Import By',
            'import_date' => 'Import Date',
        ];
    }
}
