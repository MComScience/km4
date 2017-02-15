<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_stk".
 *
 * @property integer $StkID
 * @property string $StkName
 * @property integer $StkStatus
 */
class Tbstk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_stk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['StkName', 'StkStatus'], 'required'],
            [['StkStatus'], 'integer'],
            [['StkName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'StkID' => 'Stk ID',
            'StkName' => 'Stk Name',
            'StkStatus' => 'Stk Status',
        ];
    }
}
