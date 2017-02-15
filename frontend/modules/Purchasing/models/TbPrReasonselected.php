<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "tb_pr_reasonselected".
 *
 * @property integer $ids
 * @property integer $PRID
 * @property integer $PRreasonID
 * @property integer $PRreasonIDStatus
 */
class TbPrReasonselected extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pr_reasonselected';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRreasonID', 'PRreasonIDStatus'], 'integer'],
            [['PRreasonID'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => 'Ids',
            'PRID' => 'Prid',
            'PRreasonID' => 'Prreason ID',
            'PRreasonIDStatus' => 'Prreason Idstatus',
        ];
    }
}
