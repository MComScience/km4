<?php

namespace app\modules\Purchasing\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_prstatuscount".
 *
 * @property integer $PRStatusID
 * @property string $PRStatus
 * @property string $PRStatusCount
 */
class VwPr2Prstatuscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_prstatuscount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRStatusID'], 'required'],
            [['PRStatusID', 'PRStatusCount'], 'integer'],
            [['PRStatus'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRStatusID' => 'Prstatus ID',
            'PRStatus' => 'Prstatus',
            'PRStatusCount' => 'Prstatus Count',
        ];
    }
}
