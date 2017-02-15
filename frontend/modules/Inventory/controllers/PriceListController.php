<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\modules\Inventory\models\VwQuPricelist;
use app\modules\Inventory\models\VwQuPricelistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use app\modules\Inventory\models\TbQuPricelist;
/**
 * PriceListController implements the CRUD actions for VwQuPricelist model.
 */
class PriceListController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VwQuPricelist models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $user_id = Yii::$app->user->identity->profile->user_id;
        $searchModel = new VwQuPricelistSearch();
        $dataProvider = $searchModel->SearchPriceList(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VwQuPricelist model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VwQuPricelist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VwQuPricelist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ids_qu]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit()
    {   
        $ids_qu = $_POST['ids_qu'];
        $modeledit = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$ids_qu]);
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$ids_qu]);
        $modeltbitempricelist = \app\modules\Inventory\models\TbItemPricelist::findOne(['ItemID'=>$modeledit['ItemID']]);
        $modelpack = new \app\modules\Inventory\models\Tbpackunit();
        $Item = \app\modules\Inventory\models\VwMastertmt::findOne(['TMTID_TPU' => $modeltbitempricelist['TMTID_TPU']]);
        $QTY = $modeledit['QUOrderQty'];
        $UNITCOST = $modeledit['QUUnitCost'];
        $Sum = $QTY*$UNITCOST;
        $tempDocs = $model->QUAttachment;
        $tempImg = $model->QUPicture;
        if ($modeledit->load(Yii::$app->request->post())) {
            
        } else {
             return $this->renderAjax('_update_detailtpu', [
                            'model'=>$model,
                            'modeledit' => $modeledit,
                            'modeltbitempricelist'=>$modeltbitempricelist,
                            'modelpack'=>$modelpack,
                            'ItemID' => $modeltbitempricelist['TMTID_TPU'],
                            'ItemName'=> $modeltbitempricelist['ItemName'],
                            'ItemPackSKUQty' => $modeledit['QUItemPackSKUID'],
                            'ItemUnit' => $Item['DispUnit_TMT'],
                            'QUExtenedCost' => $Sum,
                            'PackUnit' => $modeledit['QUPackUnit'],
                            'QUAttachmentPath' =>$model['QUAttachmentPath'],
                            'ids_qu'=>$ids_qu,
                ]);
        }
    }
    public function actionDownload($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttachment)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    } 
    public function actionDownload1($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttach1)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    } 
    public function actionDownload2($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttach2)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    } 
    public function actionDownload3($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttach3)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    } 
    public function actionDownload4($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUAttach4)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    } 
    public function actionDownloadPic($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUPicture)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    }
    public function actionDownloadPic1($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUPic1)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    }
    public function actionDownloadPic2($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUPic2)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    }
    public function actionDownloadPic3($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUPic3)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    }
    public function actionDownloadPic4($id, $file, $file_name) {
        $model = \app\modules\Inventory\models\TbQuPricelist::findOne(['ids_qu'=>$id]);
        if (!empty($model->QUPic4)) {
            Yii::$app->response->sendFile($model->getUploadPath() . '/' . $model->QUAttachmentPath . '/' . $file, $file_name);
        } else {
            $this->redirect(['/Inventory/dashboard/index', 'id' => $id]);
        }
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ids_qu]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionActive(){
         $ids_qu = $_POST['ids_qu'];
         $sql = "update tb_qu_pricelist set QUItemNumStatusID = 3 WHERE tb_qu_pricelist.ids_qu = $ids_qu;";
         $query = Yii::$app->db->createCommand($sql)->execute();
         echo 'updatesuccess';
    }
    public function actionNotActive(){
         $ids_qu = $_POST['ids_qu'];
         $sql = "update tb_qu_pricelist set QUItemNumStatusID = 2 WHERE tb_qu_pricelist.ids_qu = $ids_qu;";
         $query = Yii::$app->db->createCommand($sql)->execute();
         echo 'updatesuccess';
    }
    /**
     * Deletes an existing VwQuPricelist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VwQuPricelist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VwQuPricelist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VwQuPricelist::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendmailToVendor() {
        $request = Yii::$app->request;
        if ($request->post()) {
            $makrup = $request->post('makrup');
            $subject = $request->post('subject');
            $mail = $request->post('mail');
            $name = $request->post('name');
            $ccmail = $request->post('ccmail');
            if (!empty($ccmail)) {
                $emails = [$ccmail, $mail];
                $sendmail = Yii::$app->mailer->compose('@app/mail/layouts/_pricelist', [
                            'name' => $name,
                            'makrup' => $makrup,
                        ])
                        ->setFrom([Yii::$app->user->identity->email => 'UDCANCER'])
                        ->setSubject($subject);
                foreach ($emails as $mails) {
                    $sendmail->setTo($mails)
                            ->send();
                }
                return true;
            } else {
                Yii::$app->mailer->compose('@app/mail/layouts/_pricelist', [
                            'name' => $name,
                            'makrup' => $makrup,
                        ])
                        ->setFrom([Yii::$app->user->identity->email => 'UDCANCER'])
                        ->setTo($mail)
                        ->setSubject($subject)
                        ->send();
                return true;
            }
        }
    }
      public function actionExportPdf($id) {
        $model = VwQuPricelist::findOne($id);
        
        $modelfile = TbQuPricelist::find()->where(['ids_qu' => $id])->all();
        $queryvendor  = \dektrium\user\models\Profile::findOne(['VendorID' =>$model['VendorID']]);
        $queryvendor1  = \dektrium\user\models\Profile::findOne(['VendorID' =>$model['distributor_id']]);
        $content = $this->renderPartial('_content_report', [
            'model' => $model,
            'type' => 'content',
            'queryvendor' => $queryvendor,
            'queryvendor1' => $queryvendor1,
            'modelfile' => $modelfile,
        ]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => 'A4', //[60, 30], //กำหนดขนาด
            'marginTop' => 35,
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginBottom' => false,
            'marginHeader' => 5,
            'marginFooter' => 5,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'ใบเสนอราคา.pdf',
            'content' => $content,
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'ใบเสนอราคา',
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => $this->renderPartial('_content_report', [
                    'model' => $model,
                    'type' => 'header'
                ]),
                'SetFooter' => $this->renderPartial('_content_report', [
                    'model' => $model,
                    'type' => 'footer'
                ]),
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
}
