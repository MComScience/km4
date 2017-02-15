<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "tb_postatus".
 *
 * @property integer $POStatusID
 * @property string $POStatusDes
 */
class TbPostatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_postatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POStatusDes'], 'required'],
            [['POStatusDes'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POStatusID' => Yii::t('app', 'Postatus ID'),
            'POStatusDes' => Yii::t('app', 'Postatus Des'),
        ];
    }
}
