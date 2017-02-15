<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_itempack".
 *
 * @property integer $ItemPackID
 * @property integer $ItemID
 * @property string $ItemPackSKUQty
 * @property integer $ItemPackUnit
 * @property string $ItemPackBarcode
 * @property integer $ItemPackDefault
 * @property string $ItemPackNote
 */
class TbItempack extends \yii\db\ActiveRecord
{
    public $itemDispUnit;
    const YES = '1';
    const NO = '0';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_itempack';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID','ItemPackSKUQty','ItemPackBarcode'], 'required'],
            [['ItemID', 'ItemPackUnit', 'ItemPackDefault'], 'integer'],
            [['ItemPackSKUQty'], 'number'],
            [['itemDispUnit'],'safe'],
            [['ItemPackBarcode', 'ItemPackNote'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemPackID' => 'Item Pack ID',
            'ItemID' => 'รหัสสินค้า',
            'ItemPackSKUQty' => 'อัตราส่วนตัดสต๊อก',
            'ItemPackUnit' => 'หน่วยนับเรียกใช้',
            'ItemPackBarcode' => 'แพค Barcode',
            'ItemPackDefault' => 'ใช้เป็นแพคหลัก',
            'ItemPackNote' => 'Note',
            'itemDispUnit' => 'หน่วยการจ่าย'
        ];
    }
    
    public function getItemPackDefault() {
        return self::itemsAlias('ItemPackDefault');
    }
    
     public static function itemsAlias($key){

      $items = [
        'ItemPackDefault'=>[
          self::YES => 'Yes',
          self::NO=> 'No'
        ],
    ];
      return \yii\helpers\ArrayHelper::getValue($items,$key,[]);
      //return array_key_exists($key, $items) ? $items[$key] : [];
    }
}
