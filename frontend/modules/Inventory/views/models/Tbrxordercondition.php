<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_rxorder_condition".
 *
 * @property integer $order_condition_id
 * @property integer $TMTID_GPU
 * @property integer $Narcotics_required
 * @property integer $NED_required
 * @property integer $Drug2MDApprove_required
 * @property integer $DUE_required
 * @property integer $due_id
 * @property integer $OCPA_required
 * @property integer $CPR_required
 * @property integer $CreatedBy
 */
class Tbrxordercondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_rxorder_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU','Jor2_required', 'Narcotics_required', 'NED_required', 'Drug2MDApprove_required', 'DUE_required', 'due_id', 'OCPA_required', 'CPR_required', 'CreatedBy'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_condition_id' => Yii::t('app', 'Order Condition ID'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'Narcotics_required' => Yii::t('app', 'ขออนุมัติการเบิกจ่ายยาเสพติด'),
            'NED_required' => Yii::t('app', 'เหตุผลการใช้ยานอกบัญชีหลักแห่งชาติ'),
            'Drug2MDApprove_required' => Yii::t('app', 'อนุมัติการใช้ยาด้วยแพทย์ 2 ท่าน'),
            'DUE_required' => Yii::t('app', 'DUE Form'),
            'due_id' => Yii::t('app', 'Due ID'),
            'OCPA_required' => Yii::t('app', 'OCPA'),
            'CPR_required' => Yii::t('app', 'CPR'),
            'Jor2_required' => Yii::t('app', 'เอกสารประกอบการใช้ยา จ.2'),
            'CreatedBy' => Yii::t('app', 'Created By'),
        ];
    }
}
