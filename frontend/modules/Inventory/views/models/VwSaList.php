<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_sa_list".
 *
 * @property integer $SAID
 * @property string $SANum
 * @property string $SADate
 * @property integer $SATypeID
 * @property string $SAType
 * @property integer $SA_stkID
 * @property string $StkName
 * @property integer $SAStatus
 * @property string $SAStatusDesc
 * @property integer $SACreateBy
 * @property string $SANote
 */
class VwSaList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_sa_list';
    }
    
     public static function primaryKey() {
         return array('SAID');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SAID', 'SATypeID', 'SA_stkID', 'SAStatus', 'SACreateBy'], 'integer'],
            [['SADate'], 'safe'],
            [['StkName', 'SAStatusDesc'], 'required'],
            [['SANum'], 'string', 'max' => 10],
            [['SAType', 'StkName', 'SAStatusDesc'], 'string', 'max' => 50],
            [['SANote'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SAID' => 'Said',
            'SANum' => 'เอกสารเลขที่',
            'SADate' => 'วันที่',
            'SATypeID' => 'Satype ID',
            'SAType' => 'ประเภทการปรับปรุงยอด',
            'SA_stkID' => 'Sa Stk ID',
            'StkName' => 'คลังสินค้า',
            'SAStatus' => 'Sastatus',
            'SAStatusDesc' => 'สถานะปรับปรุงยอด',
            'SACreateBy' => 'Sacreate By',
            'SANote' => 'Sanote',
        ];
    }
}
