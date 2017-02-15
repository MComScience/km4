<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st_list2".
 *
 * @property integer $STID
 * @property string $STDate
 * @property string $STNum
 * @property string $SRNum
 * @property string $STCreateDate
 * @property integer $STIssue_StkID
 * @property string $Stk_issue
 * @property integer $STRecieve_StkID
 * @property string $Stk_receive
 * @property string $STRecievedDate
 * @property integer $STStatus
 * @property string $STStatusDesc
 * @property string $STNote
 */
class VwStList2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st_list2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'Stk_issue', 'Stk_receive', 'STStatusDesc'], 'required'],
            [['STID', 'STIssue_StkID', 'STRecieve_StkID', 'STStatus'], 'integer'],
            [['STDate', 'STCreateDate', 'STRecievedDate'], 'safe'],
            [['STNum', 'SRNum'], 'string', 'max' => 20],
            [['Stk_issue', 'Stk_receive', 'STStatusDesc'], 'string', 'max' => 50],
            [['STNote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'STID' => 'Stid',
            'STDate' => 'Stdate',
            'STNum' => 'Stnum',
            'SRNum' => 'Srnum',
            'STCreateDate' => 'Stcreate Date',
            'STIssue_StkID' => 'Stissue  Stk ID',
            'Stk_issue' => 'Stk Issue',
            'STRecieve_StkID' => 'Strecieve  Stk ID',
            'Stk_receive' => 'Stk Receive',
            'STRecievedDate' => 'Strecieved Date',
            'STStatus' => 'Ststatus',
            'STStatusDesc' => 'Ststatus Desc',
            'STNote' => 'Stnote',
        ];
    }
}
