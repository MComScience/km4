<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_st_list_draft".
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
class VwStListDraft extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_st_list_draft';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['STID', 'STIssue_StkID', 'STRecieve_StkID', 'STStatus'], 'integer'],
            [['STDate', 'STCreateDate', 'STRecievedDate','STPerson','STDueDate','VenderName'], 'safe'],
            [['Stk_issue', 'Stk_receive', 'STStatusDesc'], 'required'],
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
            'STDate' => Yii::t('app', 'วันที่'),
            'STNum' => Yii::t('app', 'เลขที่ใบให้ยืมสินค้า'),
            'SRNum' => 'Srnum',
            'STCreateDate' => 'Stcreate Date',
            'STIssue_StkID' => 'Stissue  Stk ID',
            'Stk_issue' => Yii::t('app', 'เบิกจากคลัง'),
            'STRecieve_StkID' => 'Strecieve  Stk ID',
            'Stk_receive' => 'Stk Receive',
            'STRecievedDate' => 'Strecieved Date',
            'STStatus' => Yii::t('app', 'สถานะใบโอนสินค้า'),
            'STStatusDesc' => Yii::t('app', 'สถานะใบโอนสินค้า'),
            'STNote' => 'Stnote',
            'STPerson' => 'STPerson',
            'STDueDate'=>Yii::t('app', 'กำหนดส่งสินค้าคืน'),
            'VenderName'=>Yii::t('app', 'ชื่อผู้ยืม'),
        ];
    }
}
