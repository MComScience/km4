<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "tb_qu_pricelist".
 *
 * @property integer $ids_qu
 * @property integer $VendorID
 * @property integer $ItemID
 * @property string $QUMQO
 * @property string $QUPackQty
 * @property string $QUPackCost
 * @property integer $QUPackUnit
 * @property string $QUOrderQty
 * @property string $QUUnitCost
 * @property integer $QUItemNumStatusID
 * @property string $QUAttachment
 * @property string $QUComment
 * @property string $QUValidDate
 * @property integer $QULeadtime
 * @property integer $QUStatusID
 * @property integer $QUCreatedBy
 *
 * @property TbItemPricelist $item
 */
class TbQuPricelist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const UPLOAD_FOLDER = 'docsfiles';
    public static function getUploadPath() {
        return "/var/www/html/procurement/backend/web/docsfiles/";
       // return Yii::getAlias('@webroot') . '/' . self::UPLOAD_FOLDER . '/';
    }

    public static function getUploadUrl() {
        return "http://www.udcancer.org/procurement/backend/web/docsfiles/";
    }
    public static function tableName()
    {
        return 'tb_qu_pricelist';
    }
    public function initialPreview($data, $field, $type = 'file') {
        $initial = [];
        $files = Json::decode($data);
        if (is_array($files)) {
            foreach ($files as $key => $value) {
                if ($type == 'file') {
                    $initial[] = "<div class='file-preview-other'><h2><i class='glyphicon glyphicon-file'></i></h2></div>";
                } elseif ($type == 'config') {
                    $initial[] = [
                        'caption' => $value,
                        'width' => '120px',
                        'url' => Url::to(['/Inventory/dashboard/deletefile', 'id' => $this->ids_qu, 'fileName' => $key, 'field' => $field]),
                        'key' => $key
                    ];
                } else {
                    $initial[] = Html::img(self::getUploadUrl() . $this->QUAttachmentPath . '/' . $value, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
                }
            }
        }
        return $initial;
    }
    
        // public function listDownloadFiles($type){
        //  $docs_file = '';
        //  if(in_array($type, ['QUAttachment'])){

        //          $data = $type==='docs'?$this->QUAttachment:$this->QUAttachment;
        //          $files = Json::decode($data);
        //         if(is_array($files)){
        //              $docs_file ='<span class="input-group-btn">
        //            <div class="btn-group" style="margin-top: 15px;">
        //                 <a class="btn btn-success shiny" href="javascript:void(0);">Download</a>
        //                 <a class="btn btn-success dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
        //                 <ul class="dropdown-menu dropdown-success" >';
        //              foreach ($files as $key => $value) {
        //                 $docs_file .= '<li>'.Html::a($value,['/Inventory/price-list/download','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0]).'</li>';
        //              }
        //              $docs_file .='</ul></div></span>';
        //         }
        //  }
        //  return $docs_file;
        // }
        public function listDownloadFiles($type){
         $docs_file = '';
         if(in_array($type, ['QUAttachment'])){

                 $data = $type==='docs'?$this->QUAttachment:$this->QUAttachment;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.Html::a('download',['/Inventory/price-list/download','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $docs_file .='';
                }
         }
         return $docs_file;
        }
        public function listDownloadFiles1($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach1'])){

                 $data = $type==='docs'?$this->QUAttach1:$this->QUAttach1;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.Html::a('download',['/Inventory/price-list/download1','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $docs_file .='';
                }
         }
         return $docs_file;
        }
        public function listDownloadFiles2($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach2'])){

                 $data = $type==='docs'?$this->QUAttach2:$this->QUAttach2;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.Html::a('download',['/Inventory/price-list/download2','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $docs_file .='';
                }
         }
         return $docs_file;
        }
        public function listDownloadFiles3($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach3'])){

                 $data = $type==='docs'?$this->QUAttach3:$this->QUAttach3;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.Html::a('download',['/Inventory/price-list/download3','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $docs_file .='';
                }
         }
         return $docs_file;
        }
        public function listDownloadFiles4($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach4'])){

                 $data = $type==='docs'?$this->QUAttach4:$this->QUAttach4;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.Html::a('download',['/Inventory/price-list/download4','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $docs_file .='';
                }
         }
         return $docs_file;
        }
        public function listDownloadPic1($type){
         $img_file = '';
         if(in_array($type, ['QUPic1'])){

                 $data = $type==='docs'?$this->QUPic1:$this->QUPic1;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.Html::a('download',['/Inventory/price-list/download-pic1','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $img_file .='';
                }
         }
         return $img_file;
        }
        public function listDownloadPic2($type){
         $img_file = '';
         if(in_array($type, ['QUPic2'])){

                 $data = $type==='docs'?$this->QUPic2:$this->QUPic2;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.Html::a('download',['/Inventory/price-list/download-pic2','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $img_file .='';
                }
         }
         return $img_file;
        }
        public function listDownloadPic3($type){
         $img_file = '';
         if(in_array($type, ['QUPic3'])){

                 $data = $type==='docs'?$this->QUPic3:$this->QUPic3;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.Html::a('download',['/Inventory/price-list/download-pic3','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $img_file .='';
                }
         }
         return $img_file;
        }
        public function listDownloadPic4($type){
         $img_file = '';
         if(in_array($type, ['QUPic4'])){

                 $data = $type==='docs'?$this->QUPic4:$this->QUPic4;
                 $files = Json::decode($data);
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.Html::a('download',['/Inventory/price-list/download-pic4','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0],['class'=>'btn btn-success btn-xs','style'=>'margin-top:5px']).'';
                     }
                     $img_file .='';
                }
         }
         return $img_file;
        }
         public function listFiles($type){
         $docs_file = '';
         if(in_array($type, ['QUAttachment'])){
                $data = $type==='docs'?$this->QUAttachment:$this->QUAttachment;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.($value).', ';
                        $i++;
                     }
                     $docs_file .='';
                }
         }

         return $docs_file;
        }
        public function listFiles1($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach1'])){
                $data = $type==='docs'?$this->QUAttach1:$this->QUAttach1;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.($value).', ';
                        $i++;
                     }
                     $docs_file .='';
                }
         }

         return $docs_file;
        }
        public function listFiles2($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach2'])){
                $data = $type==='docs'?$this->QUAttach2:$this->QUAttach2;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.($value).', ';
                        $i++;
                     }
                     $docs_file .='';
                }
         }

         return $docs_file;
        }
        public function listFiles3($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach3'])){
                $data = $type==='docs'?$this->QUAttach3:$this->QUAttach3;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.($value).', ';
                        $i++;
                     }
                     $docs_file .='';
                }
         }

         return $docs_file;
        }
        public function listFiles4($type){
         $docs_file = '';
         if(in_array($type, ['QUAttach4'])){
                $data = $type==='docs'?$this->QUAttach4:$this->QUAttach4;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $docs_file ='';
                     foreach ($files as $key => $value) {
                        $docs_file .= ''.($value).', ';
                        $i++;
                     }
                     $docs_file .='';
                }
         }

         return $docs_file;
        }
        public function listPic1($type){
         $img_file = '';
         if(in_array($type, ['QUPic1'])){
                $data = $type==='docs'?$this->QUPic1:$this->QUPic1;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.($value).', ';
                        $i++;
                     }
                     $img_file .='';
                }
         }

         return $img_file;
        }
        public function listPic2($type){
         $img_file = '';
         if(in_array($type, ['QUPic2'])){
                $data = $type==='docs'?$this->QUPic2:$this->QUPic2;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.($value).', ';
                        $i++;
                     }
                     $img_file .='';
                }
         }

         return $img_file;
        }
        public function listPic3($type){
         $img_file = '';
         if(in_array($type, ['QUPic3'])){
                $data = $type==='docs'?$this->QUPic3:$this->QUPic3;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.($value).', ';
                        $i++;
                     }
                     $img_file .='';
                }
         }

         return $img_file;
        }
        public function listPic4($type){
         $img_file = '';
         if(in_array($type, ['QUPic4'])){
                $data = $type==='docs'?$this->QUPic4:$this->QUPic4;
                $files = Json::decode($data);
                $i = 1;
                if(is_array($files)){
                     $img_file ='';
                     foreach ($files as $key => $value) {
                        $img_file .= ''.($value).', ';
                        $i++;
                     }
                     $img_file .='';
                }
         }

         return $img_file;
        }
    // public function listDownloadPic($type){
    //      $img_file = '';
    //      if(in_array($type, ['QUPicture'])){

    //              $data = $type==='docs'?$this->QUPicture:$this->QUPicture;
    //              $files = Json::decode($data);
    //             if(is_array($files)){
    //                  $img_file ='<span class="input-group-btn">
    //                <div class="btn-group" style="margin-top: 15px;">
    //                     <a class="btn btn-success shiny" href="javascript:void(0);">Download</a>
    //                     <a class="btn btn-success dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
    //                     <ul class="dropdown-menu dropdown-success" >';
    //                  foreach ($files as $key => $value) {
    //                     $img_file .= '<li>'.Html::a($value,['/Inventory/price-list/download-pic','id'=>$this->ids_qu,'file'=>$key,'file_name'=>$value,'data-pjax'=>0]).'</li>';
    //                  }
    //                  $img_file .='</ul></div></span>';
    //             }
    //      }
    //      return $img_file;
    //     }
        
        //  public function listPic($type){
        //  $img_file = '';
        //  if(in_array($type, ['QUPicture'])){
        //         $data = $type==='docs'?$this->QUPicture:$this->QUPicture;
        //         $files = Json::decode($data);
        //         $i = 1;
        //         if(is_array($files)){
        //              $img_file ='';
        //              foreach ($files as $key => $value) {
        //                 $img_file .= 'http://www.udcancer.org/procurement/backend/web/docsfiles/8zUT-TwZuITRSZgpGQDI2L/045e61ed2838fd723cfd1ee22ec2563a.jpg';
        //                 $i++;
        //              }
        //              $img_file .='';
        //         }
        //  }

        //  return $img_file;
        // }
    //     public function getThumbnailsimg($QUAttachmentPath) {
    //     $data = $this->QUPicture;
    //     $files = Json::decode($data);
    //     $preview = [];
    //     if (is_array($files)) {
    //         foreach ($files as $key => $value) {
    //             $preview[] = [
    //                 'url' => 'http://www.udcancer.org/procurement/backend/web/docsfiles/' . $QUAttachmentPath . '/' . $key, $value,
    //                 'src' => 'http://www.udcancer.org/procurement/backend/web/docsfiles/' . $QUAttachmentPath . '/' . $key, $value,
    //                 'options' => ['title' => '']
    //             ];
    //         }
    //     }
    //     return $preview;
    // }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VendorID', 'ItemID', 'QUPackUnit', 'QUItemNumStatusID', 'QULeadtime', 'QUStatusID', 'QUCreatedBy','QUItemPackSKUID','VenderName'], 'safe'],
            [['QUMQO', 'QUPackQty', 'QUPackCost', 'QUOrderQty', 'QUUnitCost'], 'safe'],
            [['QUValidDate'], 'safe'],
            //[['QUAttachment'], 'string', 'max' => 255],
            [['QUAttachment','QUPicture'],'file','maxFiles'=>10],
            [['QUComment'], 'string', 'max' => 255],
            [['QUAttachmentPath'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids_qu' => 'Ids Qu',
            'VendorID' => 'Vendor ID',
            'VenderName'=>'VenderName',
            'ItemID' => 'Item ID',
            'QUMQO' => 'Qumqo',
            'QUPackQty' => 'Qupack Qty',
            'QUPackCost' => 'Qupack Cost',
            'QUPackUnit' => 'Qupack Unit',
            'QUOrderQty' => 'Quorder Qty',
            'QUUnitCost' => 'Quunit Cost',
            'QUItemNumStatusID' => 'Quitem Num Status ID',
            'QUAttachment' => '',
            'QUPicture'=>'',
            'QUComment' => 'Qucomment',
            'QUValidDate' => 'Quvalid Date',
            'QULeadtime' => 'Quleadtime',
            'QUStatusID' => 'Qustatus ID',
            'QUCreatedBy' => 'Qucreated By',
            'QUItemPackSKUID' => 'Quitem Pack Skuid',
            'QUAttachmentPath' => 'QUAttachmentPath',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(TbItemPricelist::className(), ['ItemID' => 'ItemID']);
    }
}
