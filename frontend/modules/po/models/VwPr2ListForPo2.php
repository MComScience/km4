<?php

namespace app\modules\po\models;

use Yii;

/**
 * This is the model class for table "vw_pr2_list_for_po2".
 *
 * @property integer $PRID
 * @property string $PRNum
 * @property string $PRDate
 * @property integer $PRTypeID
 * @property string $PRType
 * @property integer $POTypeID
 * @property string $POType
 * @property string $PONum
 * @property integer $PRStatusID
 * @property integer $PRExpectDate
 * @property string $PRStatus
 */
class VwPr2ListForPo2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_pr2_list_for_po2';
    }
    
    public static function primaryKey() {
        return array(
            'PRID'
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRID', 'PRNum', 'PRDate', 'PRTypeID', 'POType'], 'required'],
            [['PRID', 'PRTypeID', 'POTypeID', 'PRStatusID', 'PRExpectDate'], 'integer'],
            [['PRDate'], 'safe'],
            [['PRNum', 'PRType', 'PONum', 'PRStatus'], 'string', 'max' => 50],
            [['POType'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRID' => 'Prid',
            'PRNum' => 'Prnum',
            'PRDate' => 'Prdate',
            'PRTypeID' => 'Prtype ID',
            'PRType' => 'Prtype',
            'POTypeID' => 'Potype ID',
            'POType' => 'Potype',
            'PONum' => 'Ponum',
            'PRStatusID' => 'Prstatus ID',
            'PRExpectDate' => 'Prexpect Date',
            'PRStatus' => 'Prstatus',
        ];
    }
    
    public function getCountStatus($StatusID) {
        if ($StatusID == 1) {
            return TbPo2Temp::find()->where(['POStatus' => $StatusID])->count('POID');
        } else if($StatusID == 'PRList') {
            return $this->find()->count('PRID');
        } else {
            return TbPo2::find()->where(['POStatus' => $StatusID])->count('POID');
        }
    }
}
