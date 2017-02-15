<?php

namespace app\modules\Inventory\controllers;

use Yii;
use app\models\TbItem;
use app\models\TbItemSearch;
use app\modules\Inventory\models\VwItemBalance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Model;
use yii\filters\AccessControl;

class AddsuppliesController extends \yii\web\Controller {

    function actionOfficematerial() {
        return $this->redirect(['create-itemnew', 'type' => 10]);
    }

    function actionHomekitchensupplies() {
        return $this->redirect(['create-itemnew', 'type' => 11]);
    }

    function actionComsupplies() {
        return $this->redirect(['create-itemnew', 'type' => 12]);
    }

    public function actionIndex() {
        $searchModel = new TbItemSearch();
        $dataProvider = $searchModel->searchaddsupplies(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        $VwItemBalance = VwItemBalance::find()->where('ItemID like "6%"')->count();
        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        $sql = "DELETE FROM tb_item WHERE ItemStatusID = 4 and CreatedBy = $CreatedBy";
        $query = Yii::$app->db->createCommand($sql)->execute();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'balancecount' => $VwItemBalance
        ]);
    }

    public function actionPricelistnondrug() {
        $searchModel = new \app\modules\Inventory\models\VwitempricelistsclSearch();
        $catid = 2;
        $dataProvider = $searchModel->searchnondrug(Yii::$app->request->queryParams, $catid);
        $dataProvider->pagination->pageSize = 10;
        return $this->render('pricelistnondrug', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id, $true) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //$model->ItemPic1 = $model->Upload($model, 'ItemPic1');
            //$model->ItemPic2 = $model->Upload($model, 'ItemPic2');
            $model->ItemStatusID = 2;
            $model->save();
            Yii::$app->session->setFlash('success', 'Save Completed!');
            return $this->refresh();
        } else {
            /*  ItemPic1 */
            if ($model['ItemPic1'] == "") {
                $initialPreview = [];
                $initialPreviewConfig = [];
            } else {
                list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->ItemPic1);
            }
            /*  ItemPic2 */
            if ($model['ItemPic2'] == "") {
                $initialPreview1 = [];
                $initialPreviewConfig1 = [];
            } else {
                list($initialPreview1, $initialPreviewConfig1) = $this->getInitialPreview1($model->ItemPic2);
            }
            return $this->render('create', [
                        'model' => $model,
                        'initialPreview' => $initialPreview,
                        'initialPreviewConfig' => $initialPreviewConfig,
                        'initialPreview1' => $initialPreview1,
                        'initialPreviewConfig1' => $initialPreviewConfig1,
                        'true' => $true,
            ]);
        }
    }

    public function actionCreateItemnew($type = null) {
        if ($type == 10) {
            $like = 61;
        } else if ($type == 11) {
            $like = 62;
        } else if ($type == 12) {
            $like = 63;
        }
        $posts = Yii::$app->db->createCommand("SELECT tb_item.ItemID FROM tb_item WHERE tb_item.ItemID LIKE '" . $like . "%' ORDER BY tb_item.ItemID DESC LIMIT 1")->queryOne();
        if ($posts != null) {
            $ItemID = $posts['ItemID'] + 1;
        } else {
            if ($type == 10) {
                $ItemID = 610000;
            } else if ($type == 11) {
                $ItemID = 620000;
            } else if ($type == 12) {
                $ItemID = 630000;
            }
        }
        $ItemCatID = 2;
        $ItemName = '';
        $TMTID_TPU = '';
        $TMTID_GPU = '';
        $TMTID_GP = '';
        $itemdosageform = '';
        $itemstmum = '';
        $itemContVal = '';
        $itemContUnit = '';
        $itemDispUnit = '';
        $CreatedBy = Yii::$app->user->identity->profile->user_id;
        Yii::$app->db->createCommand('CALL cmd_create_newitem(:ItemID,:ItemCatID,:ItemName,:TMTID_TPU,:TMTID_GPU,:TMTID_GP,:itemdosageform,:itemstmum,:itemContVal,:itemContUnit,:itemDispUnit,:CreatedBy);')
                ->bindParam(':ItemID', $ItemID)
                ->bindParam(':ItemCatID', $ItemCatID)
                ->bindParam(':ItemName', $ItemName)
                ->bindParam(':TMTID_TPU', $TMTID_TPU)
                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                ->bindParam(':TMTID_GP', $TMTID_GP)
                ->bindParam(':itemdosageform', $itemdosageform)
                ->bindParam(':itemstmum', $itemstmum)
                ->bindParam(':itemContVal', $itemContVal)
                ->bindParam(':itemContUnit', $itemContUnit)
                ->bindParam(':itemDispUnit', $itemDispUnit)
                ->bindParam(':CreatedBy', $CreatedBy)
                ->execute();
        return $this->redirect(['create', 'id' => $ItemID, 'true' => 'yes']);
    }

    /**
     * Updates an existing TbItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ItemID]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TbItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['id'];
        $sql = "
      DELETE FROM tb_item WHERE ItemID = $id;
      DELETE FROM tb_itempack WHERE ItemID = $id;
      DELETE FROM tb_stk_levelinfo WHERE ItemID = $id;
      ";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * Finds the TbItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdditemPack() {
        if ($_GET['id'] != NULL) {
            $modelitempack = \app\models\TbItempack::findOne($_GET['id']);
            if ($modelitempack->load(Yii::$app->request->post())) {
                $x = $_POST['TbItempack']['ItemPackID'];
                $ItemID = $_POST['TbItempack']['ItemID'];
                $ItemPackSKUQty = $_POST['TbItempack']['ItemPackSKUQty'];
                $ItemPackUnit = $_POST['TbItempack']['ItemPackUnit'];
                $ItemPackBarcode = $_POST['TbItempack']['ItemPackBarcode'];
                $ItemPackDefault = $_POST['TbItempack']['ItemPackDefault'];
                $ItemPackNote = $_POST['TbItempack']['ItemPackNote'];
                $TMTID_GPU = $_POST['TbItempack']['TMTID_GPU'];

                $findid = \app\models\TbItempack::findOne(['ItemPackID' => $x, 'ItemPackUnit' => $ItemPackUnit, 'ItemID' => $ItemID]);
                $find_packdefault = \app\models\TbItempack::findOne(['ItemPackID' => $x, 'ItemPackDefault' => $ItemPackDefault, 'ItemID' => $ItemID]);
                if (($findid != null && $find_packdefault != null)) {
                    Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                            ->bindParam(':x', $x)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                            ->bindParam(':ItemPackUnit', $ItemPackUnit)
                            ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                            ->bindParam(':ItemPackDefault', $ItemPackDefault)
                            ->bindParam(':ItemPackNote', $ItemPackNote)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->execute();
                    return 'success';
                } elseif ($findid == null && $find_packdefault != null) {
                    $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                    if ($checkpack == null) {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    } else {
                        return 'checkpack';
                    }
                } elseif ($findid != null && $find_packdefault == null) {
                    $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                    if ($packdefault == null) {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    } else {
                        return 'packdefault';
                    }
                } elseif ($findid == null && $find_packdefault == null) {
                    $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                    $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                    if ($checkpack != null) {
                        return 'checkpack';
                    } else if ($packdefault != null) {
                        return 'packdefault';
                    } else {
                        Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                                ->bindParam(':x', $x)
                                ->bindParam(':ItemID', $ItemID)
                                ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                                ->bindParam(':ItemPackUnit', $ItemPackUnit)
                                ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                                ->bindParam(':ItemPackDefault', $ItemPackDefault)
                                ->bindParam(':ItemPackNote', $ItemPackNote)
                                ->bindParam(':TMTID_GPU', $TMTID_GPU)
                                ->execute();
                        return 'success';
                    }
                }
            } else {
                $querydispunit = \app\modules\Inventory\models\VwItempack::findOne(['ItemPackID' => $_GET['id']]);
                $queryitemname = TbItem::findOne($modelitempack['ItemID']);
                return $this->renderAjax('_form_additempack', [
                            'modelitempack' => $modelitempack,
                            'DispUnit' => $querydispunit['DispUnit'],
                            'itemname' => $queryitemname['ItemName'],
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $x = $_POST['TbItempack']['ItemPackID'];
                $ItemID = $_POST['TbItempack']['ItemID'];
                $ItemPackSKUQty = $_POST['TbItempack']['ItemPackSKUQty'];
                $ItemPackUnit = $_POST['TbItempack']['ItemPackUnit'];
                $ItemPackBarcode = $_POST['TbItempack']['ItemPackBarcode'];
                $ItemPackDefault = $_POST['TbItempack']['ItemPackDefault'];
                $ItemPackNote = $_POST['TbItempack']['ItemPackNote'];
                $TMTID_GPU = $_POST['TbItempack']['TMTID_GPU'];
                $checkpack = $this->checkPack($ItemPackUnit, $ItemID);
                $packdefault = $this->checkPackdefault($ItemID, $ItemPackDefault);
                if ($checkpack != null) {
                    return 'checkpack';
                } else if ($packdefault != null) {
                    return 'packdefault';
                } else {
                    Yii::$app->db->createCommand('CALL cmd_itempack_save(:x,:ItemID,:ItemPackSKUQty,:ItemPackUnit,:ItemPackBarcode,:ItemPackDefault,:ItemPackNote,:TMTID_GPU);')
                            ->bindParam(':x', $x)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':ItemPackSKUQty', $ItemPackSKUQty)
                            ->bindParam(':ItemPackUnit', $ItemPackUnit)
                            ->bindParam(':ItemPackBarcode', $ItemPackBarcode)
                            ->bindParam(':ItemPackDefault', $ItemPackDefault)
                            ->bindParam(':ItemPackNote', $ItemPackNote)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->execute();
                    return 'success';
                }
            } else {
                $modelitempack = new \app\models\TbItempack();
                return $this->renderAjax('_form_additempack', [
                            'modelitempack' => $modelitempack,
                            'DispUnit' => '',
                            'itemname' => ''
                ]);
            }
        }
    }

    private function checkPack($ItemPackUnit, $ItemID) {
        $checkpack = \app\models\TbItempack::findOne(['ItemPackUnit' => $ItemPackUnit, 'ItemID' => $ItemID]);
        return $checkpack;
    }

    private function checkPackdefault($ItemID, $ItemPackDefault) {
        if ($ItemPackDefault == 1) {
            $packdefault = \app\models\TbItempack::findOne(['ItemID' => $ItemID, 'ItemPackDefault' => $ItemPackDefault]);
            return $packdefault;
        } else {
            return NULL;
        }
    }

    private function getInitialPreview($ref) {
        $datas = TbItem::find()->where(['ItemPic1' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview, $this->getTemplatePreview($value));
            array_push($initialPreviewConfig, [
                'caption' => $value->ItemPic1,
                'width' => '120px',
                'url' => Url::to(['/Inventory/additem/deletefile-ajax']),
                'key' => $value->ItemID
            ]);
        }
        return [$initialPreview, $initialPreviewConfig];
    }

    private function getInitialPreview1($ref) {
        $datas = TbItem::find()->where(['ItemPic2' => $ref])->all();
        $initialPreview1 = [];
        $initialPreviewConfig1 = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview1, $this->getTemplatePreview1($value));
            array_push($initialPreviewConfig1, [
                'caption' => $value->ItemPic2,
                'width' => '120px',
                'url' => Url::to(['/Inventory/additem/deletefile-ajax1']),
                'key' => $value->ItemID
            ]);
        }
        return [$initialPreview1, $initialPreviewConfig1];
    }

    private function getTemplatePreview($model) {
        $file = Html::img($model->getPhotoViewer1(), ['class' => 'file-preview-image', 'width' => 280]);
        return $file;
    }

    private function getTemplatePreview1($model) {
        $file = Html::img($model->getPhotoViewer2(), ['class' => 'file-preview-image', 'width' => 280]);
        return $file;
    }

    public function actionDeletefileAjax() {
        $model = TbItem::findOne(Yii::$app->request->post('key'));
        if ($model !== NULL) {
            $filename = $model->getUploadPath() . $model->ItemPic1;
            @unlink($filename);
            $model->ItemPic1 = '';
            $model->save();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function actionDeletefileAjax1() {
        $model = TbItem::findOne(Yii::$app->request->post('key'));
        if ($model !== NULL) {
            $filename = $model->getUploadPath() . $model->ItemPic2;
            @unlink($filename);
            $model->ItemPic2 = '';
            $model->save();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    function actionGettableitempack() {
        $query = \app\modules\Inventory\models\VwItempack::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table  class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_itempack">
      <thead class="bordered-success">
        <tr>
         <th width="36px" style="text-align: center;">#</th>
         <th style="text-align: center;">ปริมาณบรรจุต่อแพค</th>
         <th  style="text-align: center;">หน่วยการจ่าย</th>
         <th  style="text-align: center;">หน่วยแพค</th>
         <th  style="text-align: center;">แพคหลัก</th>
         <th  style="text-align: center;">หมายเหตุ</th>
         <th width="160px" style="text-align: center;">Actions</th>
       </tr>
     </thead>
     <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemPackSKUQty'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $_POST['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['PackUnit'] . '</td>';
                $table .= '<td style="text-align: center">';
                if ($result['ItemPackDefault'] == 1) {
                    $table .= '<b><text class="success">Yes</text></b>';
                } else {
                    $table .= '<b><text class="danger">No</text></b>';
                }
                $table .= '</td>';
                $table .= '<td>' . $result['ItemPackNote'] . '</td>';
                $table .= '<td style="text-align: center;">
          <a class="btn btn-info btn-xs" onclick="UpdateItempack(' . $result->ItemPackID . ');"> Edit</a>
          <a class="btn btn-danger btn-xs" onclick="DeleteItempack(' . $result->ItemPackID . ');" > Delete</a>
        </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemPackSKUQty'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center">' . $result['PackUnit'] . '</td>';
                $table .= '<td style="text-align: center">';
                if ($result['ItemPackDefault'] == 1) {
                    $table .= '<b><text class="success">Yes</text></b>';
                } else {
                    $table .= '<b><text class="danger">No</text></b>';
                }
                $table .= '</td>';
                $table .= '<td>' . $result['ItemPackNote'] . '</td>';
                $table .= '<td style="text-align: center;">
        <a class="btn btn-info btn-xs" disabled="" onclick="(' . $result->ItemPackID . ');"> Edit</a>
        <a class="btn btn-danger btn-xs" disabled="" onclick="(' . $result->ItemPackID . ');" > Delete</a>
      </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
</table>
</div>
';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionDeleteItempack() {
        $id = $_POST['id'];
        $sql = "DELETE FROM tb_itempack WHERE ItemPackID = $id";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionAddstklevel() {
        if ($_GET['id'] != NULL) {
            $modelstk = \app\modules\Inventory\models\TbStkLevelinfo::findOne(['ItemID' => $_GET['id'], 'StkID' => $_GET['stkid']]);
            if ($modelstk->load(Yii::$app->request->post())) {
                $ItemID = $_POST['TbStkLevelinfo']['ItemID'];
                $StkID = $_POST['TbStkLevelinfo']['StkID'];
                $ItemReorderLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemReorderLevel']);
                $ItemTargetLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemTargetLevel']);
                Yii::$app->db->createCommand('CALL cmd_stklevelinfo_save(:ItemID,:StkID,:ItemReorderLevel,:ItemTargetLevel);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':StkID', $StkID)
                        ->bindParam(':ItemReorderLevel', $ItemReorderLevel)
                        ->bindParam(':ItemTargetLevel', $ItemTargetLevel)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_addstklevel', [
                            'modelstk' => $modelstk,
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['TbStkLevelinfo']['ItemID'];
                $StkID = $_POST['TbStkLevelinfo']['StkID'];
                $ItemReorderLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemReorderLevel']);
                $ItemTargetLevel = str_replace(',', '', $_POST['TbStkLevelinfo']['ItemTargetLevel']);
                Yii::$app->db->createCommand('CALL cmd_stklevelinfo_save(:ItemID,:StkID,:ItemReorderLevel,:ItemTargetLevel);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':StkID', $StkID)
                        ->bindParam(':ItemReorderLevel', $ItemReorderLevel)
                        ->bindParam(':ItemTargetLevel', $ItemTargetLevel)
                        ->execute();
                return 'success';
            } else {
                $modelstk = new \app\modules\Inventory\models\TbStkLevelinfo();
                return $this->renderAjax('_form_addstklevel', [
                            'modelstk' => $modelstk,
                ]);
            }
        }
    }

    function actionGettablestklevel() {
        $query = \app\modules\Inventory\models\VwStklevelinfo::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table  class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_stk_levelinfo">
  <thead class="bordered-success">
    <tr>
     <th width="36px" style="text-align: center;">#</th>
     <th style="text-align: center;">คลังสินค้า</th>
     <th  style="text-align: center;">จุดสั่งซื้อสินค้า</th>
     <th  style="text-align: center;">เป้าหมายการจัดเก็บ</th>
     <th  style="text-align: center;">หน่วย</th>
     <th width="160px" style="text-align: center;">Actions</th>
   </tr>
 </thead>
 <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['StkName'] . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemReorderLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemTargetLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">
      <a class="btn btn-info btn-xs" onclick="UpdateStklevel(this);" data-id="' . $result->ItemID . '" id="' . $result->StkID . '"> Edit</a>
      <a class="btn btn-danger btn-xs" onclick="DeleteStklevel(this);" data-id="' . $result->ItemID . '" id="' . $result->StkID . '"> Delete</a>
    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center">' . $result['StkName'] . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemReorderLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . number_format($result['ItemTargetLevel'], 2) . '</td>';
                $table .= '<td style="text-align: center">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">
    <a class="btn btn-info btn-xs" disabled="" onclick="(' . $result->ItemID . ');"> Edit</a>
    <a class="btn btn-danger btn-xs" disabled="" onclick="(' . $result->ItemID . ');" > Delete</a>
  </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
</table>
</div>
';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    function actionDeleteStklevel() {
        $id = $_POST['id'];
        $stk = $_POST['stk'];
        $sql = "DELETE FROM tb_stk_levelinfo WHERE ItemID = $id and StkID = $stk";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionCheckitemidprice() {
        $query = \app\modules\Inventory\models\Tbitemidprice::findOne($_POST['ItemID']);
        return json_encode($query);
    }

    function actionGetitemprice() {
        $query = \app\modules\Inventory\models\VwItemidPrice::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table  class="kv-grid-table table table-hover table-bordered table-striped table-condensed" id="table_tb_itemid_price">
  <thead class="bordered-success">
    <tr>
     <th width="36px" style="text-align: center;">#</th>
     <th style="text-align: center;">ราคาขาย</th>
     <th  style="text-align: center;">หน่วย</th>
     <th  style="text-align: center;">วันเริ่มใช้</th>
     <th width="160px" style="text-align: center;">Actions</th>
   </tr>
 </thead>
 <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;">
      <a class="btn btn-info btn-xs" onclick="UpdateItemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
      <a class="btn btn-danger btn-xs" onclick="Deleteitemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
    </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;">' . $no . '</td>';
                $table .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;">
    <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
    <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
  </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
</table>
</div>
';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    public function actionAdditemprice() {
        if ($_GET['id'] != null) {
            $model = \app\modules\Inventory\models\Tbitemidprice::findOne(['ItemID' => $_GET['id'], 'ItemPriceEffectiveDate' => $_GET['date']]);
            $modelprice = \app\modules\Inventory\models\VwItemidPrice::findOne(['ItemID' => $_GET['id'], 'ItemPriceEffectiveDate' => $_GET['date']]);
            if ($model->load(Yii::$app->request->post())) {
                $ItemID = $_POST['Tbitemidprice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['Tbitemidprice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['Tbitemidprice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                return $this->renderAjax('_form_itemidprice', [
                            'model' => $model,
                            'ItemName' => $modelprice['ItemName'],
                            'DispUnit' => $modelprice['DispUnit'],
                            'itemprice' => number_format($model['ItemPrice'], 2),
                ]);
            }
        } else {
            if (Yii::$app->request->post()) {
                $ItemID = $_POST['Tbitemidprice']['ItemID'];
                $ItemPrice = str_replace(',', '', $_POST['Tbitemidprice']['ItemPrice']);
                $ItemPriceEffectiveDate = Yii::$app->componentdate->convertThaiToMysqlDate2($_POST['Tbitemidprice']['ItemPriceEffectiveDate']);
                $ItemPriceStatus = '2';
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                Yii::$app->db->createCommand('CALL cmd_itemprice_save(:ItemID,:ItemPrice,:ItemPriceEffectiveDate,:ItemPriceStatus,:CreatedBy);')
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':ItemPriceEffectiveDate', $ItemPriceEffectiveDate)
                        ->bindParam(':ItemPriceStatus', $ItemPriceStatus)
                        ->bindParam(':CreatedBy', $CreatedBy)
                        ->execute();
                return 'success';
            } else {
                $model = new \app\modules\Inventory\models\Tbitemidprice();
                return $this->renderAjax('_form_itemidprice', [
                            'model' => $model,
                            'ItemName' => '',
                            'DispUnit' => '',
                            'itemprice' => '',
                ]);
            }
        }
    }

    function actionDeleteItemprice() {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $sql = "DELETE FROM tb_itemid_price WHERE ItemID = $id and ItemPriceEffectiveDate = '$date'";
        $query = Yii::$app->db->createCommand($sql)->execute();
    }

    function actionDiscontinus() {
        $ItemID = $_POST['ItemID'];
        Yii::$app->db->createCommand('CALL cmd_item_discontinue(:ItemID);')
                ->bindParam(':ItemID', $ItemID)
                ->execute();
    }

    function actionPriceDetails($id) {
        if (isset($id)) {
            $query = \app\modules\Inventory\models\VwItemidPrice::findOne(['ItemID' => $id]);
            $itemprice = \app\modules\Inventory\models\VwItemidPrice::find()->where(['ItemID' => $id])->all();
            return $this->renderPartial('_price-details', [
                        'itemprice' => $itemprice,
                        'dataitem' => $query
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    function actionGetitempriceedit() {
        $query = \app\modules\Inventory\models\VwItemidPrice::find()->where(['ItemID' => $_POST['itemid']])->all();
        $table = '<table  class="table table-bordered table-hover dt-responsive" id="table_tb_itemid_price">
  <thead >
    <tr>
      <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#</th>
      <th  style="text-align: center;color:black;background-color: #ddd">ราคาขาย</th>
      <th  style="text-align: center;color:black;background-color: #ddd">หน่วย</th>
      <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
      <th  style="text-align: center;color:black;background-color: #ddd">Actios</th>
    </tr>
  </thead>
  <tbody>';
        $no = 1;
        if ($_POST['edit'] == 'true') {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
        <a class="btn btn-info btn-xs" onclick="UpdateItemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
        <a class="btn btn-danger btn-xs" onclick="Deleteitemprice(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
      </td>';
                $table .= '</tr>';
                $no++;
            }
        } else {
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td style="text-align: center;color:black;">' . $no . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . number_format($result['ItemPrice'], 2) . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . $result['DispUnit'] . '</td>';
                $table .= '<td style="text-align: center;color:black;">' . Yii::$app->componentdate->convertMysqlToThaiDate2($result['ItemPriceEffectiveDate']) . '</td>';
                $table .= '<td style="text-align: center;color:black;">
      <a class="btn btn-info btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Edit</a>
      <a class="btn btn-danger btn-xs" disabled="" onclick="(this);" data-id="' . $result->ItemID . '" id="' . $result->ItemPriceEffectiveDate . '"> Delete</a>
    </td>';
                $table .= '</tr>';
                $no++;
            }
        }

        $table .= '</tr></tbody>
</table>
</div>
';
        $arr = array(
            'table' => $table,
        );
        return json_encode($arr);
    }

    private function updateCreditPrice($itemid) {
        $medical = \app\modules\Inventory\models\TbCreditItem::find()->where(['ItemID' => $itemid, 'cr_status' => 2])->all();
        if (!empty($medical)) {
            foreach ($medical as $data) {
                $medicalid[] = $data['medical_right_group_id']; #query หา medical_right_group_id ที่บันทึกแล้ว แล้วเก็บ id ไว้ใน []
            }
            $querynotsave = \app\modules\Inventory\models\Tbmedicalrightgroup::find()
                    ->where(['NOT IN', 'medical_right_group_id', $medicalid]) #query หา medical_right_group_id ที่ยังไม่ได้บันทึก
                    //->andWhere('cr_status = :prtypeid', [':prtypeid' => 2])
                    ->all();
            if (!empty($querynotsave)) { #ถ้า Query เจอ
                foreach ($querynotsave as $data) {
                    $medicalkeys[] = $data['medical_right_group_id']; #loop เอา id ที่ยังไม่ได้บันทึก
                }
                $CreatedBy = Yii::$app->user->identity->profile->user_id;
                foreach ($medicalkeys as $value) { #insert ลง tabel
                    if ($value == 9) {
                        $status = 3;
                    } else {
                        $status = 2;
                    }
                    $sql = "
                  REPLACE INTO tb_credit_item
                  SET
                  ItemID= '$itemid',
                  medical_right_group_id= $value,
                  cr_status = '$status',
                  cr_effectiveDate = NOW(),
                  CreatedBy = $CreatedBy     
                  ";
                    $query = Yii::$app->db->createCommand($sql)->execute();
                }
            }
        } else {
            $CreatedBy = Yii::$app->user->identity->profile->user_id;
            $findallmedical = \app\modules\Inventory\models\Tbmedicalrightgroup::find()->all();
            foreach ($findallmedical as $data) {
                $medicalkeys[] = $data['medical_right_group_id']; #loop เอา id ที่ยังไม่ได้บันทึก
            }
            #insert
            foreach ($medicalkeys as $value) { #insert ลง tabel
                if ($value == 9) {
                    $status = 3;
                } else {
                    $status = 2;
                }
                $sql = "
              REPLACE INTO tb_credit_item
              SET
              ItemID= '$itemid',
              medical_right_group_id= $value,
              cr_status = '$status',
              cr_effectiveDate = NOW(),
              CreatedBy = $CreatedBy     
              ";
                $query = Yii::$app->db->createCommand($sql)->execute();
            }
        }
    }

    public function actionEditCredit() {
        /*
          $sourceModel = new \app\modules\Purchasing\models\TbPritemdetail2Search();
          $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams());
          $models = $dataProvider->getModels();
         */
        $itemid = $_GET['id'];
        $this->updateCreditPrice($itemid);
        $sourceModel = new \app\models\TbCreditItemSearch();
        $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams(), $itemid);
        $models = $dataProvider->getModels();
        $model1 = \app\modules\Inventory\models\Vwitempricelistscl::findOne(['ItemID' => $itemid]);
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $Itemprice = str_replace(',', '', $_POST['Vwitempricelistscl']['ItemPrice']);
            $sql = ""
                    . "UPDATE tb_itemid_price
            SET 
            ItemPrice='$Itemprice'
            WHERE tb_itemid_price.ItemID= '$itemid'
            ";
            $query = Yii::$app->db->createCommand($sql)->execute();
            $count = 0;
            foreach ($models as $index => $model) {
                $model->cr_status = 2;
                $model->CreatedBy = 2;
                $model->cr_effectiveDate = Yii::$app->componentdate->convertThaiToMysqlDate2($model->cr_effectiveDate);
                $model->cr_price = str_replace(',', '', $model->cr_price);
                // populate and save records for each model
                if ($model->save()) {
                    $count++;
                }
            }
            //Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            //return $this->refresh();
            return 'success';
        } else {
            return $this->renderAjax('_form_credit_price', [
                        'model' => $sourceModel,
                        'dataProvider' => $dataProvider,
                        'model1' => $model1,
                        'itemid' => $itemid,
            ]);
        }
    }

}
