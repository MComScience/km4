<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_logger".
 *
 * @property integer $id
 * @property string $action
 * @property string $dates
 * @property string $datetime
 * @property integer $user_id
 * @property string $ip
 * @property string $action_id
 */
class TbLogger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_logger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dates', 'datetime'], 'safe'],
            [['user_id'], 'integer'],
            [['action', 'ip'], 'string', 'max' => 255],
            [['action_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'action' => Yii::t('app', 'Action'),
            'dates' => Yii::t('app', 'Dates'),
            'datetime' => Yii::t('app', 'Datetime'),
            'user_id' => Yii::t('app', 'User ID'),
            'ip' => Yii::t('app', 'Ip'),
            'action_id' => Yii::t('app', 'Action ID'),
        ];
    }
}
