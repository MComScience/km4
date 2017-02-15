<?php

namespace app\modules\pr\models;

use Yii;

/**
 * This is the model class for table "tb_prbudget".
 *
 * @property integer $PRbudgetID
 * @property string $PRbudget
 * @property string $PRbudgetDesc
 */
class TbPrbudget extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_prbudget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRbudgetID'], 'required'],
            [['PRbudgetID'], 'integer'],
            [['PRbudget'], 'string', 'max' => 50],
            [['PRbudgetDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRbudgetID' => 'Prbudget ID',
            'PRbudget' => 'Prbudget',
            'PRbudgetDesc' => 'Prbudget Desc',
        ];
    }
}
