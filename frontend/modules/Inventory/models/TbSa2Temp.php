<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sa2_temp".
 *
 * @property integer $SAID
 * @property string $SADate
 * @property string $SANum
 * @property integer $DepartmentID
 * @property integer $SectionID
 * @property integer $SATypeID
 * @property integer $SA_stkID
 * @property integer $SAStatus
 * @property integer $SACreateBy
 * @property string $SACreateDate
 * @property integer $SAApproveBy
 * @property string $SAApproveDate
 * @property integer $SARejectApproveBy
 * @property string $SARejectApproveDate
 * @property string $SANote
 */
class TbSa2Temp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sa2_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SADate', 'SACreateDate', 'SAApproveDate', 'SARejectApproveDate'], 'safe'],
            [['DepartmentID', 'SectionID', 'SATypeID', 'SA_stkID', 'SAStatus', 'SACreateBy', 'SAApproveBy', 'SARejectApproveBy'], 'integer'],
            [['SANum'], 'string', 'max' => 10],
            [['SANote'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SAID' => 'Said',
            'SADate' => 'วันที่',
            'SANum' => 'เลขที่ปรับปรุงยอดคงคลัง',
            'DepartmentID' => 'Department ID',
            'SectionID' => 'Section ID',
            'SATypeID' => 'ประเภทปรับปรุงยอด',
            'SA_stkID' => 'คลังสินค้า',
            'SAStatus' => 'สถานะปรับปรุงยอด',
            'SACreateBy' => 'Sacreate By',
            'SACreateDate' => 'Sacreate Date',
            'SAApproveBy' => 'Saapprove By',
            'SAApproveDate' => 'Saapprove Date',
            'SARejectApproveBy' => 'Sareject Approve By',
            'SARejectApproveDate' => 'Sareject Approve Date',
            'SANote' => 'Note',
        ];
    }
}
