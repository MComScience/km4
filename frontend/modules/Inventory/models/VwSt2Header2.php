<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st2_header".
 *
 * @property integer $STID
 * @property string $STDate
 * @property string $STNum
 * @property string $SRNum
 * @property integer $STCreateBy
 * @property string $STCreateDate
 * @property integer $STIssue_StkID
 * @property string $StkID_Issue
 * @property integer $STReceive_StkID
 * @property string $StkID_Receive
 * @property string $STRecievedDate
 * @property integer $STRecievedBy
 * @property integer $STStatus
 * @property string $STNote
 * @property string $STStatusDesc
 */
class VwSt2Header2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st2_header2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'STCreateBy', 'STReceive_StkID', 'STRecievedBy', 'STStatus','STTypeID'], 'integer'],
            [['STDate', 'STCreateDate', 'STRecievedDate','VenderName','DocRefID'], 'safe'],
            [['StkID_Issue', 'StkID_Receive', 'STStatusDesc','STIssue_StkID'], 'required'],
            [['STNum', 'SRNum'], 'string', 'max' => 20],
            [['StkID_Issue', 'StkID_Receive', 'STStatusDesc'], 'string', 'max' => 50],
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
            'STNum' => 'STNum',
            'SRNum' => 'Srnum',
            'STCreateBy' => 'Stcreate By',
            'STCreateDate' => 'Stcreate Date',
            'STIssue_StkID' => 'Stissue  Stk ID',
            'StkID_Issue' => 'Stk Id  Issue',
            'STReceive_StkID' => 'Streceive  Stk ID',
            'StkID_Receive' => 'Stk Id  Receive',
            'STRecievedDate' => 'Strecieved Date',
            'STRecievedBy' => 'Strecieved By',
            'STStatus' => 'Ststatus',
            'STNote' => 'Stnote',
            'STStatusDesc' => 'Ststatus Desc',
            'STTypeID'=>'STTypeID',
            'VenderName'=>'VenderName',
            'DocRefID'=>'DocRefID',
        ];
    }
}