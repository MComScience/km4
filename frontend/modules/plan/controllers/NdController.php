<?php

namespace app\modules\plan\controllers;

use Yii;
use app\modules\plan\models\TbPcplan;
use app\modules\plan\models\TbPcplanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;
use app\modules\plan\models\TbPcplannddetail;
use app\modules\pr\models\VwItemListNd;
use app\modules\pr\models\TbSection;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * NdController implements the CRUD actions for TbPcplan model.
 */
class NdController extends Controller {

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
     * Lists all TbPcplan models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TbPcplanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbPcplan model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
        return $this->render('update', [
                    'model' => $model,
                    'section' => $section,
        ]);
    }

    /**
     * Creates a new TbPcplan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $userid = \Yii::$app->user->getId();
        TbPcplan::deleteAll(['PCPlanCreatedBy' => $userid, 'PCPlanTypeID' => NULL]);
        $max = TbPcplan::find()->max('PCPlanNum');
        $substr = substr($max, 5) + 1;
        $dat = substr(date('Y') + 543, 2, 4);
        $sprintf = sprintf("%04d", $substr);
        $PCPlanNum = 'PC' . $dat . '-' . $sprintf;
        Yii::$app->db->createCommand('CALL cmd_plangpu_create_header(:userid,:PCPlanNum);')->bindParam(':userid', $userid)->bindParam(':PCPlanNum', $PCPlanNum)->queryOne();
        return $this->redirect(['update', 'id' => $PCPlanNum]);
    }

    /**
     * Updates an existing TbPcplan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $posted = Yii::$app->request->post('TbPcplan');
            $Total = TbPcplannddetail::find()->where(['PCPlanNum' => $posted['PCPlanNum']])->sum('PCPlanNDExtendedCost');
            $model->PCPlanNum = empty($posted['PCPlanNum']) ? null : $posted['PCPlanNum'];
            $model->PCPlanDate = empty($posted['PCPlanDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanDate']);
            $model->PCPlanTypeID = empty($posted['PCPlanTypeID']) ? null : $posted['PCPlanTypeID'];
            $model->DepartmentID = empty($posted['DepartmentID']) ? null : $posted['DepartmentID'];
            $model->SectionID = empty($posted['SectionID']) ? null : $posted['SectionID'];
            $model->PCPlanBeginDate = empty($posted['PCPlanBeginDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanBeginDate']);
            $model->PCPlanEndDate = empty($posted['PCPlanEndDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanEndDate']);
            $model->Pcplandrugandnondrug = 2;
            $model->PCPlanTotal = $Total;
            $model->save();
            return 'success';
        } else {
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
            ]);
        }
    }

    /**
     * Deletes an existing TbPcplan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbPcplan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TbPcplan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbPcplan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGettableDetails() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = TbPcplannddetail::find()->where(['PCPlanNum' => $request->post('PCPlanNum')])->all();
            $table = '<table class="default kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap dataTable no-footer" width="100%" id="tabledata">
                        <thead>
                            <tr>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    #
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รหัสสินค้า
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รายละเอียดสินค้า
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    ราคา/หน่วย
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    จำนวน
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    หน่วย
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รวมเป็นเงิน
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>';
            $total = [0];
            foreach ($query as $v) {
                if ($request->post('type') == 'edit') {
                    $action = Html::a(\kartik\icons\Icon::show('edit') . 'Edit', false, [
                                'class' => 'btn btn-primary btn-xs edit',
                                'title' => 'Edit',
                                'onclick' => 'EditDetails(' . $v['ids'] . ');',
                            ]) . ' '
                            . Html::a(\kartik\icons\Icon::show('trash-o') . 'Delete', false, [
                                'class' => 'btn btn-danger btn-xs',
                                'title' => 'Edit',
                                'onclick' => 'DeleteDetail(' . $v['ids'] . ');',
                    ]);
                } else {
                    $action = '';
                }

                $table .= '<tr data-key="' . $v['ids'] . '">';
                $table .= Html::tag('td', '', ['style' => 'text-align: center;']);
                $table .= Html::tag('td', $v['ItemID'], ['style' => 'text-align: center;']);
                $table .= Html::tag('td', $v->dataonview->ItemName, ['style' => 'text-align: left;']);
                $table .= Html::tag('td', number_format($v['PCPlanNDUnitCost'], 2), ['style' => 'text-align: right;']);
                $table .= Html::tag('td', number_format($v['PCPlanNDQty'], 2), ['style' => 'text-align: center;']);
                $table .= Html::tag('td', $v->dataonview->DispUnit, ['style' => 'text-align: center;']);
                $table .= Html::tag('td', number_format($v['PCPlanNDUnitCost'] * $v['PCPlanNDQty'], 2), ['style' => 'text-align: right;']);
                $table .= Html::tag('td', $action, ['style' => 'text-align: center;white-space: nowrap;']);
                $table .= '</tr>';
                $total[] = ($v['PCPlanNDUnitCost'] * $v['PCPlanNDQty']);
            }
            $table .= '</tbody><tfoot>';
            $table .= '<tr>';
            $table .= Html::tag('td', 'รวมเป็นเงิน', ['style' => 'text-align: right;font-size:14pt;', 'colspan' => '6']);
            $table .= Html::tag('td', number_format(array_sum($total), 2), ['style' => 'text-align: right;font-size:14pt;',]);
            $table .= Html::tag('td', 'บาท', ['style' => 'text-align: center;font-size:14pt;']);
            $table .= '</tr>';
            $table .= '</tfoot></table>';
            return $table;
        }
    }

    public function actionDetails($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query = TbPcplannddetail::find()->where(['PCPlanNum' => $id])->all();
                $table = '<table class="default kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap dataTable no-footer" width="100%" id="tabledata">
                        <thead>
                            <tr>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    #
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รหัสสินค้า
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รายละเอียดสินค้า
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    ราคา/หน่วย
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    จำนวน
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    หน่วย
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    รวมเป็นเงิน
                                </th>
                                <th style="text-align: center;white-space: nowrap;background-color: white;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>';
                $total = [0];
                foreach ($query as $v) {
                    if ($request->post('type') == 'edit') {
                        $action = Html::a(\kartik\icons\Icon::show('edit') . 'Edit', false, [
                                    'class' => 'btn btn-primary btn-xs edit',
                                    'title' => 'Edit',
                                    'onclick' => 'EditDetails(' . $v['ids'] . ');',
                                ]) . ' '
                                . Html::a(\kartik\icons\Icon::show('trash-o') . 'Delete', false, [
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Edit',
                                    'onclick' => 'DeleteDetail(' . $v['ids'] . ');',
                        ]);
                    } else {
                        $action = '';
                    }

                    $table .= '<tr data-key="' . $v['ids'] . '">';
                    $table .= Html::tag('td', '', ['style' => 'text-align: center;']);
                    $table .= Html::tag('td', $v['ItemID'], ['style' => 'text-align: center;']);
                    $table .= Html::tag('td', $v->dataonview->ItemName, ['style' => 'text-align: left;']);
                    $table .= Html::tag('td', number_format($v['PCPlanNDUnitCost'], 2), ['style' => 'text-align: right;']);
                    $table .= Html::tag('td', number_format($v['PCPlanNDQty'], 2), ['style' => 'text-align: center;']);
                    $table .= Html::tag('td', $v->dataonview->DispUnit, ['style' => 'text-align: center;']);
                    $table .= Html::tag('td', number_format($v['PCPlanNDUnitCost'] * $v['PCPlanNDQty'], 2), ['style' => 'text-align: right;']);
                    $table .= Html::tag('td', $action, ['style' => 'text-align: center;white-space: nowrap;']);
                    $table .= '</tr>';
                    $total[] = ($v['PCPlanNDUnitCost'] * $v['PCPlanNDQty']);
                }
                $table .= '</tbody><tfoot>';
                $table .= '<tr>';
                $table .= Html::tag('td', 'รวมเป็นเงิน', ['style' => 'text-align: right;font-size:14pt;', 'colspan' => '6']);
                $table .= Html::tag('td', number_format(array_sum($total), 2), ['style' => 'text-align: right;font-size:14pt;',]);
                $table .= Html::tag('td', 'บาท', ['style' => 'text-align: center;font-size:14pt;']);
                $table .= '</tr>';
                $table .= '</tfoot></table>';
                return [
                    'title' => '<strong>แผนจัดซื้อเลขที่ ' . $id . '</strong>',
                    'content' => $this->renderAjax('view', [
                        'table' => $table,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionGetTableNd() {
        $request = Yii::$app->request;
        if ($request->isGet) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = VwItemListNd::find()
                    ->select('vw_item_list_nd.ItemID,vw_item_list_nd.ItemNDMedSupply,vw_item_list_nd.ItemName')
                    ->all();
            $table = '<table id="datatable-nd" class="default kv-grid-table table table-hover table-condensed kv-table-wrap dataTable no-footer dtr-inline" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">รหัสสินค้า</th>
                            <th style="text-align:center">ประเภทเวชภัณฑ์</th>
                            <th style="text-align:center">ชื่อสินค้า</th>
                            <th style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($query as $v) {
                $table .= '<tr>';
                $table .= Html::tag('td', $v['ItemID'], ['style' => 'text-align: center;']);
                $table .= Html::tag('td', $v['ItemNDMedSupply'], ['style' => 'text-align: center;']);
                $table .= Html::tag('td', $v['ItemName'], ['style' => 'text-align: left;']);
                $table .= Html::tag('td', Html::a('Select', false, ['class' => 'btn btn-sm btn-success']), ['style' => 'text-align: center;', 'onclick' => 'AdditemDetail(' . $v['ItemID'] . ');']);
                $table .= '</tr>';
            }
            $table .= '</tbody>
        </table>';
            return $table;
        }
    }

    public function actionSaveFromheader() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $posted = $request->post('TbPcplan');
            $model = $this->findModel($posted['PCPlanNum']);
            $model->PCPlanNum = empty($posted['PCPlanNum']) ? null : $posted['PCPlanNum'];
            $model->PCPlanDate = empty($posted['PCPlanDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanDate']);
            $model->PCPlanTypeID = empty($posted['PCPlanTypeID']) ? null : $posted['PCPlanTypeID'];
            $model->DepartmentID = empty($posted['DepartmentID']) ? null : $posted['DepartmentID'];
            $model->SectionID = empty($posted['SectionID']) ? null : $posted['SectionID'];
            $model->PCPlanBeginDate = empty($posted['PCPlanBeginDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanBeginDate']);
            $model->PCPlanEndDate = empty($posted['PCPlanEndDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanEndDate']);
            $model->save();
            return 'success';
        }
    }

    public function actionChildDepartment() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = TbSection::find()->andWhere(['DepartmentID' => $id])->asArray()->all();
            $selected = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['SectionID'], 'name' => $account['SectionDecs']];
                    if ($i == 0) {
                        $selected = $account['SectionID'];
                    }
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected' => $selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getSection($id) {
        $datas = TbSection::find()->where(['DepartmentID' => $id])->all();
        return $this->MapData($datas, 'SectionID', 'SectionDecs');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionAddItemdetail() {
        $request = Yii::$app->request;
        $model = new TbPcplannddetail();
        if ($request->isPost) {
            $posted = $request->post('TbPcplannddetail');
            $model->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
            $model->PCPlanNum = empty($posted['PCPlanNum']) ? null : $posted['PCPlanNum'];
            $model->PCPlanNDItemEffectDate = empty($posted['PCPlanNDItemEffectDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanNDItemEffectDate']);
            $model->PCPlanNDQty = empty($posted['PCPlanNDQty']) ? null : $this->strNumber($posted['PCPlanNDQty']);
            $model->PCPlanNDUnitCost = empty($posted['PCPlanNDUnitCost']) ? null : $this->strNumber($posted['PCPlanNDUnitCost']);
            $model->PCPlanNDExtendedCost = empty($posted['PCPlanNDExtendedCost']) ? null : $this->strNumber($posted['PCPlanNDExtendedCost']);
            $model->PCPlanItemStatusID = 1;
            $model->save();
            return 'success';
        } else if ($request->isGet) {
            $query = VwItemListNd::findOne(['ItemID' => $request->get('ItemID')]);
            if ((TbPcplannddetail::findAll(['ItemID' => $request->get('ItemID'), 'PCPlanNum' => $request->get('PCPlanNum')])) != null) {
                return 'false';
            } else {
                return $this->renderAjax('_from_detail', [
                            'model' => $model,
                            'query' => $query,
                ]);
            }
        }
    }

    public function actionEditDetail($ids) {
        $request = Yii::$app->request;
        if (($model = TbPcplannddetail::findOne($ids)) !== null) {
            if ($request->isPost) {
                $posted = $request->post('TbPcplannddetail');
                $model->ItemID = empty($posted['ItemID']) ? null : $posted['ItemID'];
                $model->PCPlanNum = empty($posted['PCPlanNum']) ? null : $posted['PCPlanNum'];
                $model->PCPlanNDItemEffectDate = empty($posted['PCPlanNDItemEffectDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($posted['PCPlanNDItemEffectDate']);
                $model->PCPlanNDQty = empty($posted['PCPlanNDQty']) ? null : $this->strNumber($posted['PCPlanNDQty']);
                $model->PCPlanNDUnitCost = empty($posted['PCPlanNDUnitCost']) ? null : $this->strNumber($posted['PCPlanNDUnitCost']);
                $model->PCPlanNDExtendedCost = empty($posted['PCPlanNDExtendedCost']) ? null : $this->strNumber($posted['PCPlanNDExtendedCost']);
                $model->PCPlanItemStatusID = 1;
                $model->save();
                return 'success';
            } else {
                $query = VwItemListNd::findOne(['ItemID' => $model['ItemID']]);
                return $this->renderAjax('_from_detail', [
                            'model' => $model,
                            'query' => $query,
                ]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function strNumber($number) {
        if (!empty($number)) {
            return str_replace(',', '', $number);
        } else {
            return NULL;
        }
    }

    public function actionDeleteDetail($ids) {
        TbPcplannddetail::findOne($ids)->delete();
    }

    public function actionCheckPlanofyear() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbPcplan::find()
                    ->where('PCPlanTypeID = :PCPlanTypeID', [':PCPlanTypeID' => 3])
                    ->andWhere(['between', 'PCPlanDate', date('Y-m-d', strtotime('first day of January')), date('Y-m-d', strtotime('last day of December'))])
                    ->all();
            if ($model != null) {
                return 'oftheyear';
            } else {
                return 'false';
            }
        }
    }

    public function actionSendtoVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $Total = TbPcplannddetail::find()->where(['PCPlanNum' => $request->post('PCPlanNum')])->sum('PCPlanNDExtendedCost');
            $model = $this->findModel($request->post('PCPlanNum'));
            $model->PCPlanTotal = $Total;
            $model->PCPlanStatusID = 4;
            $model->save();
            Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'ส่งอนุมัติแผนจัดซื้อเลขที่ ' . $request->post('PCPlanNum') . ' เรียบร้อยแล้ว!',
            ]);
            return 'success';
        }
    }

    public function actionVerify($data) {
        $model = $this->findModel($data);
        $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
        return $this->render('update', [
                    'model' => $model,
                    'section' => $section,
        ]);
    }

    public function actionApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $posted = $request->post('TbPcplan');
            $model = $this->findModel($posted['PCPlanNum']);
            $Total = TbPcplannddetail::find()->where(['PCPlanNum' => $posted['PCPlanNum']])->sum('PCPlanNDExtendedCost');
            $model->PCPlanStatusID = 5;
            $model->PCPlanTotal = $Total;
            $model->PCPlanApproveBy = \Yii::$app->user->getId();
            $model->PCPlanApproveDate = date('Y-m-d');
            $model->PCPlanApproveTime = date('H:i:s');
            $model->PCPlanManagerApproveBy = \Yii::$app->user->getId();
            $model->PCPlanManagerApproveDate = date('Y-m-d');
            $model->PCPlanManagerApproveTime = date('H:i:s');
            $model->save();
            TbPcplannddetail::updateAll(['PCPlanItemStatusID' => 2], ['PCPlanNum' => $posted['PCPlanNum']]);
            Yii::$app->getSession()->setFlash('alert1', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'อนุมัติแผนจัดซื้อเลขที่ ' . $posted['PCPlanNum'] . ' เรียบร้อยแล้ว!',
            ]);
            return 'success';
        }
    }

}
