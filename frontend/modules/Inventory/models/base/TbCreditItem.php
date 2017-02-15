<?php

namespace app\modules\Inventory\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tb_credit_item".
 *
 * @property integer $ItemID
 * @property string $medical_right_group_id
 * @property integer $maininscl_id
 * @property string $cr_price
 * @property integer $cr_status
 * @property string $cr_effectiveDate
 * @property integer $CreatedBy
 */
class TbCreditItem extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID', 'medical_right_group_id'], 'required'],
            [['ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            [['cr_price'], 'number'],
            [['cr_effectiveDate'], 'safe'],
            [['medical_right_group_id'], 'string', 'max' => 50],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_credit_item';
    }

    /**
     * 
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock 
     * 
     */
    public function optimisticLock() {
        return 'lock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => 'Item ID',
            'medical_right_group_id' => 'Medical Right Group ID',
            'maininscl_id' => 'Maininscl ID',
            'cr_price' => 'Cr Price',
            'cr_status' => 'Cr Status',
            'cr_effectiveDate' => 'Cr Effective Date',
            'CreatedBy' => 'Created By',
        ];
    }

/**
     * @inheritdoc
     * @return type mixed
     */ 
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => UUIDBehavior::className(),
                'column' => 'id',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\Inventory\models\TbCreditItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\Inventory\models\TbCreditItemQuery(get_called_class());
    }
}
