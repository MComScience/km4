<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use app\models\Uploads;
use app\models\TbItemndmedsupply;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use app\models\TbItemstatus;
use app\models\TbMastertmt;

class TbItem extends \yii\db\ActiveRecord
{
    const UPLOAD_FOLDER = 'photolibrarys';
    public $UPLOAD_FOLDER = 'photolibrarys';
    const YES = '1';
    const NO = '0';
    
    const NO1 = '0';
    const Yes1 = '1';
    public $FSN_TMT;



    public $upload_foler = 'uploads';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_item';
    }

    /**
     * @inheritdoc
     */
     public function rules() {
        return [
            [['ItemName', 'ItemExpDateControl'], 'required'],
            [['ItemID', 'ItemCatID', 'ItemNDMedSupplyCatID', 'ItemExpDateControl', 'ItemStatusID', 'itempBarcodeNum', 'itemMinOrderLeadtime'], 'integer'],
            [['ItemStdUnitPrice', 'ItemPackPrice', 'ItemMinOrderQty', 'ItemPackVal'], 'number'],
            [['ItemDateUpdateStdPrice', 'ItemDateEffectiveStdPrice', 'ItemDateChange', 'itemstmum', 'ItemName','Item_label','Item_workingcode'], 'safe'],
            [['TMTID_TPU', 'ItemSpecPrep'], 'string', 'max' => 150],
            [['TMTID_GPU', 'TMTID_GP'], 'string', 'max' => 11],
            [['ItemPackSize', 'ItemUpdateFlag', 'ItemAutoLotNum', 'itemdosageform', 'itemstrunit', 'itemstrdeno', 'itemstrdennounit', 'itemContVal', 'itemContUnit', 'itemDispUnit', 'itemPackSizeUnit', 'ref'], 'string', 'max' => 50],
            [['ItemReorderLevel', 'ItemTargetLevel'], 'string', 'max' => 100],
            // [['ItemPic3', 'ItemPic4', 'ItemPic1', 'ItemPic2'], 'string', 'max' => 255],
            [['ref', 'ItemPic1', 'ItemPic2', 'ItemPic3', 'ItemPic4'], 'unique'],
            [['ItemPic1', 'ItemPic2', 'ItemPic3', 'ItemPic4'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png,jpg,gif,bmp,jpeg'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ItemID' => Yii::t('app', 'รหัสสินค้า'),
            'ItemCatID' => Yii::t('app', 'ประเภทยาและเวชภัณฑ์'),
            'ItemNDMedSupplyCatID' => Yii::t('app', 'ประเภทเวชภัณฑ์'),
            'ItemName' => Yii::t('app', 'ชื่อสินค้า'),
            'TMTID_TPU' => Yii::t('app', 'รหัสยาการค้า'),
            'TMTID_GPU' => Yii::t('app', 'รหัสยาสามัญบรรจุภัณฑ์'),
            'TMTID_GP' => Yii::t('app', 'รหัสยาสามัญ'),
            'ItemSpecPrep' => Yii::t('app', 'รูปแบบการเตรียมยา'),
            'ItemStdUnitPrice' => Yii::t('app', 'ราคาต่อหน่วย ใช้เป็นราคาอ้างอิงในการคิดจำนวนเงินค่ายาที่จ่าย'),
            'ItemDateUpdateStdPrice' => Yii::t('app', 'Item Date Update Std Price'),
            'ItemDateEffectiveStdPrice' => Yii::t('app', 'Item Date Effective Std Price'),
            'ItemPackPrice' => Yii::t('app', 'Item Pack Price'),
            'ItemPackSize' => Yii::t('app', 'Item Pack Size'),
            'ItemUpdateFlag' => Yii::t('app', 'Item Update Flag'),
            'ItemDateChange' => Yii::t('app', 'Item Date Change'),
            'ItemAutoLotNum' => Yii::t('app', 'Item Auto Lot Num'),
            'ItemExpDateControl' => Yii::t('app', 'เปลี่ยนสินค้าก่อนหมดอายุ'),
            'ItemReorderLevel' => Yii::t('app', 'Item Reorder Level'),
            'ItemTargetLevel' => Yii::t('app', 'Item Target Level'),
            'ItemMinOrderQty' => Yii::t('app', 'Item Min Order Qty'),
            'ItemStatusID' => Yii::t('app', 'Item Status ID'),
            'itemdosageform' => Yii::t('app', 'รูปแบบยา'),
            'itemstmum' => Yii::t('app', 'ความแรงยา'),
            'itemstrunit' => Yii::t('app', 'Itemstrunit'),
            'itemstrdeno' => Yii::t('app', 'Itemstrdeno'),
            'itemstrdennounit' => Yii::t('app', 'Itemstrdennounit'),
            'itemContVal' => Yii::t('app', 'ขนาดบรรจุ'),
            'itemContUnit' => Yii::t('app', 'Item Cont Unit'),
            'itemDispUnit' => Yii::t('app', 'Item Disp Unit'),
            'itemPackSizeUnit' => Yii::t('app', 'Item Pack Size Unit'),
            'itempBarcodeNum' => Yii::t('app', 'Item Barcode'),
            'itemMinOrderLeadtime' => Yii::t('app', 'Item Min Order Leadtime'),
            'ref' => Yii::t('app', 'เลข fk กับ upload ใช้กับ upload ajax'),
            'ItemPic1' => Yii::t('app', 'Item Pic1'),
            'ItemPic2' => Yii::t('app', 'Item Pic2'),
            'ItemPic3' => Yii::t('app', 'Item Pic3'),
            'ItemPic4' => Yii::t('app', 'Item Pic4'),
            'ItemPackVal' => Yii::t('app', 'ปริมาณแพค'),
        ];
    }
    
   /* public function Upload($model, $attribute) {
        $photo = UploadedFile::getInstance($model, $attribute);
        //$this->CreateDir($attribute);
        $path = $this->getUploadPath();
        if ($this->validate() && $photo !== null) {
            $fileName = md5($photo->baseName . time()) . '.' . $photo->extension;
            //$fileName = $photo->baseName . '.' . $photo->extension;
            if ($photo->saveAs($path . $fileName)) {
                
                return $fileName;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }*/

    public function Upload($model, $attribute) {
        $photo = UploadedFile::getInstance($model, $attribute);
        //$this->CreateDir($attribute);
        $path = $this->getUploadPath();
        $width = 285;
        $height = 160;
        if ($this->validate() && $photo !== null) {
            $fileName = md5($photo->baseName . time()) . '.' . $photo->extension;
            $photo->saveAs($path . $fileName);
            $this->isImage(Url::base(true) . $path . $fileName);
            $file = $path . $fileName;
            $image = Yii::$app->image->load($file);
            $image->resize($width, $height);
            $image->save($path . '/thumbnail/' . $fileName);
            return $fileName;
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function isImage($filePath) {
        return @is_array(getimagesize($filePath)) ? true : false;
    }

    public function getItemdetail() {
        return $this->hasOne(\app\modules\Purchasing\models\VwItemList::className(), ['ItemID' => 'ItemID']);
    }

    public function getTmtdetail() {
        return $this->hasOne(TbMastertmt::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }

    public function getUploadPath() {
        return Yii::getAlias('@webroot') . '/' . $this->UPLOAD_FOLDER . '/';
    }

     public function getUploadUrl1() {
        return Yii::getAlias('@web') . '/' . $this->UPLOAD_FOLDER . '/';
    }

    public function getPhotoViewer1() {
        return empty($this->ItemPic1) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic1;
    }

    public function getPhotoViewer2() {
        return empty($this->ItemPic2) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic2;
    }

    public function getThumbnails($ref) {
        $uploadFiles = TbItem::find()->where(['ItemPic1' => $ref])->all();
        $preview = [];
        foreach ($uploadFiles as $file) {
            $preview[] = [
                'url' => self::getUploadUrl1(true) . $ref,
                'src' => self::getUploadUrl1(true) . $ref,
                    // 'options' => ['title' => $event_name]
            ];
        }
        return $preview;
    }
    public function getItemAutoLotNum() {
        return self::itemsAlias('ItemAutoLotNum');
    }
    
    public static function itemsAlias($key){

      $items = [
        'ItemAutoLotNum'=>[
          self::YES => 'Yes',
          self::NO=> 'No'
        ],
    ];
      return \yii\helpers\ArrayHelper::getValue($items,$key,[]);
      //return array_key_exists($key, $items) ? $items[$key] : [];
    }
    
    
    
    // private function CreateDir($folderName) {
    //     if ($folderName != NULL) {
    //         $basePath = TbItem::getUploadPath1();
    //         if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
    //             BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
    //         }
    //     }
    //     return;
    // }

    // public function getUploadPath1() {
    //     return Yii::getAlias('@webroot') . '/' . $this->upload_foler . '/';
    // }

    // public function getUploadUrl1() {
    //     return Yii::getAlias('@web') . '/' . $this->upload_foler . '/';
    // }

    // public function getPhotoViewer1() {
    //     return empty($this->ItemPic1) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic1;
    // }

    // public function getPhotoViewer2() {
    //     return empty($this->ItemPic2) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic2;
    // }

    // public function getPhotoViewer3() {
    //     return empty($this->ItemPic3) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic3;
    // }

    // public function getPhotoViewer4() {
    //     return empty($this->ItemPic4) ? Yii::getAlias('@web') . '/images/none.png' : $this->getUploadUrl1() . $this->ItemPic4;
    // }

    // public function getUploadPath() {
    //     return Yii::getAlias('@webroot') . '/' . $this->UPLOAD_FOLDER . '/';
    // }

    // public static function getUploadUrl() {
    //     return Url::base(true) . '/' . self::UPLOAD_FOLDER . '/';
    // }

    // public function getThumbnails($ItemPic2) {
    //     $uploadFiles = Uploads::find()->where(['ItemPic2' => $ItemPic2])->all();
    //     $preview = [];
    //     foreach ($uploadFiles as $file) {
    //         $preview[] = [
    //             'url' => self::getUploadUrl(true) . $ItemPic2 . '/' . $file->real_filename1,
    //             'src' => self::getUploadUrl(true) . $ItemPic2 . '/thumbnail/' . $file->real_filename1,
    //                 //'options' => ['title' => $event_name]
    //         ];
    //     }
    //     return $preview;
    // }

    public function getItemnd() {
        return $this->hasOne(TbItemndmedsupply::className(), ['ItemNDMedSupplyCatID' => 'ItemNDMedSupplyCatID']);
    }
    
    // public function getItemstatus() {
    //     return $this->hasOne(TbItemstatus::className(), ['ItemStatusID' => 'ItemStatusID']);
    // }

    // public function getItemSex() {
    //     return self::itemsAlias('ItemAutoLotNum');
    // }
    
    //  public static function itemsAlias($key){

    //   $items = [
    //     'ItemAutoLotNum'=>[
    //       self::YES => 'Yes',
    //       self::NO=> 'No'
    //     ],
    // ];
    //   return ArrayHelper::getValue($items,$key,[]);
    //   //return array_key_exists($key, $items) ? $items[$key] : [];
    // }
    
    // public function getItemHighDrugAlertType() {
    //     return self::itemsAlias1('HighDrugAlertType');
    // }
    
    //  public static function itemsAlias1($key){

    //   $items = [
    //     'HighDrugAlertType'=>[
    //       self::YES => 'Yes',
    //       self::NO => 'No'
    //     ],
    // ];
    //   return ArrayHelper::getValue($items,$key,[]);
    //   //return array_key_exists($key, $items) ? $items[$key] : [];
    // }
    
    // public function getItemHighDrugAlertType1() {
    //     return self::itemsAlias2('HighDrugAlertType');
    // }
    
    //  public static function itemsAlias2($key){

    //   $items = [
    //     'HighDrugAlertType'=>[
    //       self::NO1 => 'No',
    //       self::Yes1 => 'Yes'
    //     ],
    // ];
    //   return ArrayHelper::getValue($items,$key,[]);
    //   //return array_key_exists($key, $items) ? $items[$key] : [];
    // }
    
    
    public function getFsntmt() {
        return $this->hasOne(TbMastertmt::className(), ['TMTID_TPU' => 'TMTID_TPU']);
    }
    public function getDataonviewbalance() {
        return $this->hasOne(\app\modules\Inventory\models\VwItemBalance::className(), ['ItemID' => 'ItemID']);
    }
    
     
}
