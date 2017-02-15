<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_po2_postatuscount".
 *
 * @property integer $POStatusID
 * @property string $POStatusDes
 * @property string $POStatusCount
 */
class VwPo2Postatuscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_po2_postatuscount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POStatusID', 'POStatusCount'], 'integer'],
            [['POStatusDes'], 'required'],
            [['POStatusDes'], 'string', 'max' => 50]
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
            'POStatusCount' => Yii::t('app', 'Postatus Count'),
        ];
    }
}
