<?php

namespace app\modules\purqr\controllers;

use Yii;
use app\modules\purqr\models\tbqr2;
use app\modules\purqr\models\tbqr2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\purqr\models\vwqritemdetail;
use app\modules\purqr\models\vwvendorqrselected;
use app\modules\purqr\models\vwvendorprofile;
use app\modules\purqr\models\tbvendorqrselected;
use app\modules\purqr\models\vwItemlistqs;
use app\modules\purqr\models\tbqritemdetail2new;
use app\modules\purqr\models\tbItempack;
use app\modules\purqr\models\vwqr2header;
use app\modules\purqr\models\vwqr2headerSearch;

/**
 * QrController implements the CRUD actions for tbqr2 model.
 */
class QrController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all tbqr2 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new vwqr2headerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single tbqr2 model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id) {
//        return $this->render('view', [
//                    'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new tbqr2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $QRID = $post['tbqr2']['QRID'];
            $POTypeID = $post['tbqr2']['POTypeID'];
            $QRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['tbqr2']['QRDate']);
            $QRExpectDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['tbqr2']['QRExpectDate']);
            $QRmassage = $post['tbqr2']['QRmassage'];
            $QRDeliveDay = $post['tbqr2']['QRDeliveryDay'];
            $QRValidDay = $post['tbqr2']['QRValidDay'];
            Yii::$app->db->createCommand('CALL cmd_qr2_savedraft(:QRID,:POTypeID,:QRDate,:QRExpectDate,:QRmassage,:QRDeliveryDay,:QRValidDay);')
                    ->bindParam(':QRID', $QRID)
                    ->bindParam(':POTypeID', $POTypeID)
                    ->bindParam(':QRDate', $QRDate)
                    ->bindParam(':QRExpectDate', $QRExpectDate)
                    ->bindParam(':QRmassage', $QRmassage)
                    ->bindParam(':QRDeliveryDay', $QRDeliveDay)
                    ->bindParam(':QRValidDay', $QRValidDay)
                    ->execute();
            $qrnum = tbqr2::findOne($QRID);
            return $qrnum['QRNum'];
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing tbqr2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->QRID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing tbqr2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteQr() {
        $request = Yii::$app->request;
        $this->findModel($request->post('id'))->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the tbqr2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return tbqr2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = tbqr2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionQuerytb1() {
        $request = Yii::$app->request;
        if ($request->isAjax) {

            $model = vwqritemdetail::find()->where(['QRID' => $request->post('QRID')])->all();
            $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tb1">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รายละเอียด</th>
                                            <th>จำนวน</th>
                                            <th>หน่วย</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>';
            $no = 1;
            foreach ($model as $result) {
                $table .='<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td>' . $result['ItemDetail'] . '</td>';
//                $table .= '<td style="text-align: center;">' . $result['ItemType'] . '</td>';
                $table .= '<td style="text-align: right;">' . number_format($result['QRQty'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['QRUnit'] . '</td>';
                $table .='<td style="text-align: center;">'
                        . '<a class="btn btn-info btn-sm"  onclick="EditItem(' . $result->ids . ');" >Edit</a>' . ' '
                        . '<a class="btn btn-danger btn-sm" onclick="DeleteItem(' . $result->ids . ');" >Delete</a>'
                        . '</td>';
                $table .='</tr>';
                $no++;
            }
            $table .='</tbody></table>';
            return json_encode($table);
        }
    }

    public function actionViewQuerytb1() {
        $request = Yii::$app->request;
        if ($request->isAjax) {

            $model = vwqritemdetail::find()->where(['QRID' => $request->post('QRID')])->all();
            $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tb1">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รายละเอียด</th>
                                            <th>จำนวน</th>
                                            <th>หน่วย</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>';
            $no = 1;
            foreach ($model as $result) {
                $table .='<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td>' . $result['ItemDetail'] . '</td>';
//                $table .= '<td style="text-align: center;">' . $result['ItemType'] . '</td>';
                $table .= '<td style="text-align: right;">' . number_format($result['QRQty'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['QRUnit'] . '</td>';
                $table .='<td style="text-align: center;">'
                        . '<a class="btn btn-info btn-sm" disabled="" onclick="(' . $result->ids . ');" >Edit</a>' . ' '
                        . '<a class="btn btn-danger btn-sm" disabled="" onclick="(' . $result->ids . ');" >Delete</a>'
                        . '</td>';
                $table .='</tr>';
                $no++;
            }
            $table .='</tbody></table>';
            return json_encode($table);
        }
    }

    public function actionQuerytb2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {

            $model = vwvendorqrselected::find()->where(['QRID' => $request->post('QRID')])->all();
            $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tb2">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ลำดับ</th>
                                            <th style="text-align: center;">รหัสผู้ขาย</th>
                                            <th style="text-align: center;">ชื่อผู้จำหน่าย</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>';
            $no = 1;
            foreach ($model as $result) {
                $table .='<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
                $table .= '<td style="text-align: left;">' . $result['VenderName'] . '</td>';
                $table .='<td style="text-align: center;">'
                        . '<a class="btn btn-danger btn-sm" onclick="DeleteVendor(' . $result->vendor_selected_id . ');" >Delete</a>'
                        . '</td>';
                $table .='</tr>';
                $no++;
            }
            $table .='</tbody></table>';
            return json_encode($table);
        }
    }

    public function actionViewQuerytb2() {
        $request = Yii::$app->request;
        if ($request->isAjax) {

            $model = vwvendorqrselected::find()->where(['QRID' => $request->post('QRID')])->all();
            $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tb2">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รหัสผู้ขาย</th>
                                            <th>ชื่อผู้จำหน่าย</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>';
            $no = 1;
            foreach ($model as $result) {
                $table .='<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
                $table .= '<td style="text-align: left;">' . $result['VenderName'] . '</td>';
                $table .='<td style="text-align: center;">'
                        . '<a class="btn btn-danger btn-sm" disabled="" onclick="(' . $result->vendor_selected_id . ');" >Delete</a>'
                        . '</td>';
                $table .='</tr>';
                $no++;
            }
            $table .='</tbody></table>';
            return json_encode($table);
        }
    }

    public function actionGettbvendor() {
        $model = vwvendorprofile::find()->all();
        $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbvendor">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ลำดับ</th>
                                            <th style="text-align: center;">รหัสผู้จำหน่าย</th>
                                            <th style="text-align: center;">ชื่อผู้จำหน่าย</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>';
        $no = 1;
        foreach ($model as $result) {
            $table .='<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td style="text-align: center;">' . $result['VendorID'] . '</td>';
            $table .= '<td style="text-align: left;">' . $result['VenderName'] . '</td>';
            $table .='<td style="text-align: center;">'
                    . '<a class="btn btn-success btn-sm" onclick="SelectVendor(' . $result->VendorID . ');" >Select</a>'
                    . '</td>';
            $table .='</tr>';
            $no++;
        }
        $table .='</tbody></table>';
        return json_encode($table);
    }

    public function actionGettbgpu() {
        $model = vwItemlistqs::find()->where(['ItemCatID' => 1])->all();
        $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbgpu">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ลำดับ</th>
                                            <th style="text-align: center;">รหัสยาสามัญ</th>
                                            <th style="text-align: center;">รายละเอียด</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>';
        $no = 1;
        foreach ($model as $result) {
            $table .='<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td style="text-align: center;">' . $result['TMTID_GPU'] . '</td>';
            $table .= '<td style="text-align: left;">' . $result['FSN_GPU'] . '</td>';
            $table .='<td style="text-align: center;">'
                    . '<a class="btn btn-success btn-sm" onclick="SelectGPU(' . $result->ItemID . ');" >Select</a>'
                    . '</td>';
            $table .='</tr>';
            $no++;
        }
        $table .='</tbody></table>';
        return json_encode($table);
    }

    public function actionGettbtpu() {
        $model = vwItemlistqs::find()->where(['ItemCatID' => 1])->all();
        $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbtpu">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ลำดับ</th>
                                            <th style="text-align: center;">รหัสยาการค้า</th>
                                            <th style="text-align: center;">รายละเอียด</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>';
        $no = 1;
        foreach ($model as $result) {
            $table .='<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td style="text-align: center;">' . $result['TMTID_TPU'] . '</td>';
            $table .= '<td style="text-align: left;">' . $result['ItemName'] . '</td>';
            $table .='<td style="text-align: center;">'
                    . '<a class="btn btn-success btn-sm" onclick="SelectTPU(' . $result->ItemID . ');" >Select</a>'
                    . '</td>';
            $table .='</tr>';
            $no++;
        }
        $table .='</tbody></table>';
        return json_encode($table);
    }

    public function actionGettbnd() {
        $model = vwItemlistqs::find()->where(['ItemCatID' => 2])->all();
        $table = ' <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbnd">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">ลำดับ</th>
                                            <th style="text-align: center;">รหัสสินค้า</th>
                                            <th style="text-align: center;">รายละเอียด</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>';
        $no = 1;
        foreach ($model as $result) {
            $table .='<tr>';
            $table .= '<td style="text-align: center;">' . $no . '</td>';
            $table .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $table .= '<td style="text-align: left;">' . $result['ItemName'] . '</td>';
            $table .='<td style="text-align: center;">'
                    . '<a class="btn btn-success btn-sm" onclick="SelectND(' . $result->ItemID . ');" >Select</a>'
                    . '</td>';
            $table .='</tr>';
            $no++;
        }
        $table .='</tbody></table>';
        return json_encode($table);
    }

    public function actionVendorSelected() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $QRID = $request->post('QRID');
            $VendorID = $request->post('userid');
            Yii::$app->db->createCommand('CALL cmd_qr2_vendorselected(:QRID,:VendorID);')
                    ->bindParam(':QRID', $QRID)
                    ->bindParam(':VendorID', $VendorID)
                    ->execute();
            return json_encode('success');
        }
    }

    public function actionDeleteVendor() {
        $request = Yii::$app->request;
        $model = tbvendorqrselected::findOne($request->post('id'));
        $model->delete();
    }

    public function actionDeleteitem() {
        $request = Yii::$app->request;
        $model = tbqritemdetail2new::findOne($request->post('id'));
        $model->delete();
    }

    public function actionSelectItem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $model = new tbqritemdetail2new();
            $packunit = tbItempack::find()->where(['ItemID' => $request->post('id')])->all();
            if (!empty($packunit)) {
                foreach ($packunit as $data) {
                    $unitid[] = $data['ItemPackUnit'];
                }
            } else {
                $unitid = null;
            }
            $query = vwItemlistqs::findOne($request->post('id'));
            return $this->renderAjax('_formitem', [
                        'model' => $model,
                        'unitid' => $unitid,
                        'query' => $query,
                        'QRID' => $request->post('QRID'),
                        'ItemPackUnit' => null,
                        'SKU' => null,
            ]);
        }
    }

    public function actionGetqty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $packunit = tbItempack::findOne(['ItemID' => $request->post('itemid'), 'ItemPackUnit' => $request->post('PackUnitID')]);
            return json_encode(number_format($packunit['ItemPackSKUQty'], 2));
        }
    }

    public function actionSelectTpu() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $model = new tbqritemdetail2new();
            $packunit = tbmastertmt::find()->where(['ItemID' => $request->post('id')])->all();
            if (!empty($packunit)) {
                foreach ($packunit as $data) {
                    $unitid[] = $data['TMTID_TPU'];
                }
            } else {
                $unitid = null;
            }
            $query = vwItemlistqs::findOne($request->post('id'));
            return $this->renderAjax('_formtpu', [
                        'model' => $model,
                        'unitid' => $unitid,
                        'query' => $query,
                        'QRID' => $request->post('QRID'),
                        'ItemPackUnit' => null,
                        'SKU' => null,
            ]);
        }
    }

    public function actionSaveitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $ids = !empty($post['tbqritemdetail2new']['ids']) ? $post['tbqritemdetail2new']['ids'] : NULL;
            $ItemID = !empty($post['tbqritemdetail2new']['ItemID']) ? $post['tbqritemdetail2new']['ItemID'] : NULL;
            $TMTID_GPU = !empty($post['tbqritemdetail2new']['TMTID_GPU']) ? $post['tbqritemdetail2new']['TMTID_GPU'] : NULL;
            $TMTID_TPU = !empty($post['tbqritemdetail2new']['TMTID_TPU']) ? $post['tbqritemdetail2new']['TMTID_TPU'] : NULL;
            $QROrderQty = !empty($post['tbqritemdetail2new']['QROrderQty']) ? str_replace(',', '', $post['tbqritemdetail2new']['QROrderQty']) : NULL;
            $QRPackQty = !empty($post['tbqritemdetail2new']['QRPackQty']) ? str_replace(',', '', $post['tbqritemdetail2new']['QRPackQty']) : NULL;
            $ItemPackID = !empty($post['tbqritemdetail2new']['ItemPackID']) ? $post['tbqritemdetail2new']['ItemPackID'] : NULL;
            $QRID = !empty($post['tbqritemdetail2new']['QRID']) ? $post['tbqritemdetail2new']['QRID'] : NULL;
            $ItemType = !empty($post['tbqritemdetail2new']['ItemType']) ? $post['tbqritemdetail2new']['ItemType'] : NULL;
            $itempackid = tbItempack::findOne(['ItemID' => $ItemID, 'ItemPackUnit' => $ItemPackID]);
            $PackID = $itempackid['ItemPackID'];
            if ($ItemType == 'GPU') {
                Yii::$app->db->createCommand('CALL cmd_qr2_itemsave_gpu(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:QROrderQty,:QRPackQty,:ItemPackID,:QRID);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':TMTID_TPU', $TMTID_TPU)
                        ->bindParam(':QROrderQty', $QROrderQty)
                        ->bindParam(':QRPackQty', $QRPackQty)
                        ->bindParam(':ItemPackID', $PackID)
                        ->bindParam(':QRID', $QRID)
                        // ->bindParam(':ItemType', $ItemType)
                        ->execute();
            } elseif ($ItemType == 'TPU') {
                Yii::$app->db->createCommand('CALL cmd_qr2_itemsave_tpu(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:QROrderQty,:QRPackQty,:ItemPackID,:QRID);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':TMTID_TPU', $TMTID_TPU)
                        ->bindParam(':QROrderQty', $QROrderQty)
                        ->bindParam(':QRPackQty', $QRPackQty)
                        ->bindParam(':ItemPackID', $PackID)
                        ->bindParam(':QRID', $QRID)
                        // ->bindParam(':ItemType', $ItemType)
                        ->execute();
            } elseif ($ItemType == 'ND') {
                Yii::$app->db->createCommand('CALL cmd_qr2_itemsave_nd(:ids,:ItemID,:TMTID_GPU,:TMTID_TPU,:QROrderQty,:QRPackQty,:ItemPackID,:QRID);')
                        ->bindParam(':ids', $ids)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':TMTID_GPU', $TMTID_GPU)
                        ->bindParam(':TMTID_TPU', $TMTID_TPU)
                        ->bindParam(':QROrderQty', $QROrderQty)
                        ->bindParam(':QRPackQty', $QRPackQty)
                        ->bindParam(':ItemPackID', $PackID)
                        ->bindParam(':QRID', $QRID)
                        // ->bindParam(':ItemType', $ItemType)
                        ->execute();
            }
            return true;
        }
    }

    public function actionEditItem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $model = tbqritemdetail2new::findOne($request->post('id'));
            $packunit = tbItempack::find()->where(['ItemID' => $model['ItemID']])->all();
            if (!empty($packunit)) {
                foreach ($packunit as $data) {
                    $unitid[] = $data['ItemPackUnit'];
                }
            } else {
                $unitid = null;
            }
            $itempackid = tbItempack::findOne(['ItemPackID' => $model['ItemPackID']]);
            if (!empty($itempackid)) {
                $ItemPackUnit = $itempackid['ItemPackUnit'];
                $SKU = $itempackid['ItemPackSKUQty'];
            } else {
                $ItemPackUnit = NULL;
                $SKU = null;
            }

            $query = vwItemlistqs::findOne($model['ItemID']);
            return $this->renderAjax('_formitem', [
                        'model' => $model,
                        'unitid' => $unitid,
                        'query' => $query,
                        'QRID' => $model['QRID'],
                        'ItemPackUnit' => $ItemPackUnit,
                        'SKU' => $SKU,
            ]);
        }
    }

    public function actionCreateheader() {

        $userid = Yii::$app->user->identity->id;
        Yii::$app->db->createCommand('CALL cmd_createqr2_header(:userid);')
                ->bindParam(':userid', $userid)
                ->execute();
        $id = tbqr2::find()
                ->select('max(QRID)')
                ->scalar();
        return $this->redirect(['create', 'id' => $id]);
    }

    public function actionSendmail() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $queryqr = vwqr2header::findOne(['QRID' => $request->post('QRID')]);
            $queryvendor = vwvendorqrselected::find()->where(['QRID' => $request->post('QRID')])->all();
            $querydetail = vwqritemdetail::find()->where(['QRID' => $request->post('QRID')])->all();
            if (!empty($queryvendor)) {
                foreach ($queryvendor as $data) {
                    $sendmail = Yii::$app->mailer->compose('@app/mail/layouts/qr2email', [
                                'queryqr' => $queryqr,
                                'vendername' => $data['VenderName'],
                                'querydetail' => $querydetail
                            ])
                            ->setFrom(['procurementuch@gmail.com' => 'UDONTHANI CANCER HOSPITAL'])
                            ->setSubject('ขอสืบราคาสินค้า')
                            ->setTo($data['VenderEmail'])
                            ->send();
                }
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $QRID = $post['tbqr2']['QRID'];
            $POTypeID = $post['tbqr2']['POTypeID'];
            $QRDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['tbqr2']['QRDate']);
            $QRExpectDate = Yii::$app->componentdate->convertThaiToMysqlDate2($post['tbqr2']['QRExpectDate']);
            $QRmassage = $post['tbqr2']['QRmassage'];
            $QRDeliveDay = $post['tbqr2']['QRDeliveryDay'];
            $QRValidDay = $post['tbqr2']['QRValidDay'];
            Yii::$app->db->createCommand('CALL cmd_qr2_savedraft(:QRID,:POTypeID,:QRDate,:QRExpectDate,:QRmassage,:QRDeliveryDay,:QRValidDay);')
                    ->bindParam(':QRID', $QRID)
                    ->bindParam(':POTypeID', $POTypeID)
                    ->bindParam(':QRDate', $QRDate)
                    ->bindParam(':QRExpectDate', $QRExpectDate)
                    ->bindParam(':QRmassage', $QRmassage)
                    ->bindParam(':QRDeliveryDay', $QRDeliveDay)
                    ->bindParam(':QRValidDay', $QRValidDay)
                    ->execute();
            $qrnum = tbqr2::findOne($QRID);
            return $qrnum['QRNum'];
        } else {
            return $this->render('_form_view', [
                        'model' => $model,
            ]);
        }
    }

}
