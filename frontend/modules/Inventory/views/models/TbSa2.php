<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_sa2".
 *
 * @property integer $SAID
 * @property string $SADate
 * @property string $SANum
 * @property integer $SATypeID
 * @property integer $SA_stkID
 * @property integer $SAStatus
 * @property integer $SACreateBy
 * @property string $SACreateDate
 * @property string $SAApproveBy
 * @property string $SAApproveDate
 * @property integer $SARejectApproveBy
 * @property string $SARejectApproveDate
 * @property string $SANote
 * @property string $SARejectNote
 */
class TbSa2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_sa2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SADate', 'SACreateDate', 'SAApproveDate', 'SARejectApproveDate'], 'safe'],
            [['SATypeID', 'SA_stkID', 'SAStatus', 'SACreateBy', 'SARejectApproveBy'], 'integer'],
            [['SANum'], 'string', 'max' => 10],
            [['SAApproveBy', 'SANote', 'SARejectNote'], 'string', 'max' => 255],
            [['SA_stkID'], 'required'],
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
            'SANum' => 'เอกสารเลขที่',
            'SATypeID' => 'ประเภทเอกสาร',
            'SA_stkID' => 'คลังสินค้า',
            'SAStatus' => 'สถานะปรับปรุงยอดสินค้า',
            'SACreateBy' => 'Sacreate By',
            'SACreateDate' => 'Sacreate Date',
            'SAApproveBy' => 'Saapprove By',
            'SAApproveDate' => 'Saapprove Date',
            'SARejectApproveBy' => 'Sareject Approve By',
            'SARejectApproveDate' => 'Sareject Approve Date',
            'SANote' => 'Sanote',
            'SARejectNote' => 'Sareject Note',
        ];
    }
}
