<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "vw_protocol_for_cr".
 *
 * @property string $Dx10CA
 * @property string $dx_custom_name
 * @property string $protocol_name
 * @property string $chemo_state_desc
 * @property string $regimen_paycode
 */
class VwProtocolForCr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_protocol_for_cr';
    }
    
    public static function primaryKey() {
        return array(
            'Dx10CA'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Dx10CA'], 'string', 'max' => 162],
            [['dx_custom_name', 'protocol_name', 'chemo_state_desc'], 'string', 'max' => 100],
            [['regimen_paycode'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Dx10CA' => 'Dx10 Ca',
            'dx_custom_name' => 'Dx Custom Name',
            'protocol_name' => 'Protocol Name',
            'chemo_state_desc' => 'Chemo State Desc',
            'regimen_paycode' => 'Regimen Paycode',
        ];
    }
}
