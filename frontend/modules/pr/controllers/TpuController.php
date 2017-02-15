<?php

namespace app\modules\pr\controllers;

use Yii;
use app\modules\pr\models\TbPr2Temp;
use app\modules\pr\models\TbPr2TempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\data\SqlDataProvider;
#models
use app\modules\pr\models\TbPr2;
use app\modules\pr\models\TbPritemdetail2Temp;
use app\modules\pr\models\TbSection;
use app\modules\pr\models\TbPrReason;
use app\modules\pr\models\TbPrReasonselected;
use app\modules\pr\models\VwItemListTpuplanAvalible;
use app\modules\pr\models\VwItemListTpu;
use app\modules\pr\models\TbItempack;
use app\modules\pr\models\VwTpuplanDetailAvalible;
use app\modules\pr\models\TbPotype;
use app\modules\pr\models\TbPritemdetail2;
use app\modules\pr\models\VwStkStatusSearch;
use app\modules\pr\models\VwQuPricelistSearch;
use app\modules\pr\models\VwPurchasingHistorySearch;
use app\modules\pr\models\VwGpustdCost;

class TpuController extends Controller {

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

    public function actionIndex() {
        /*
          $searchModel = new TbPr2TempSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          ]); */
    }

    public function actionCreate() {
        $maxidtemp = TbPr2Temp::find()->max('PRID');
        $maxid = TbPr2::find()->max('PRID');

        if ($maxidtemp < $maxid) {
            $PRID = $maxid + 1;
        } else {
            $PRID = $maxidtemp + 1;
        }

        $userid = Yii::$app->user->identity->id;
        $PRTypeID = 2;
        $DepartmentID = '1';
        $SectionID = '1';
        $POTypeID = '';
        Yii::$app->db->createCommand('CALL cmd_pr2_create_PR(:x,:PRID,:PRTypeID,:DepartmentID,:SectionID,:POTypeID);')
                ->bindParam(':x', $userid)
                ->bindParam(':PRID', $PRID)
                ->bindParam(':PRTypeID', $PRTypeID)
                ->bindParam(':DepartmentID', $DepartmentID)
                ->bindParam(':SectionID', $SectionID)
                ->bindParam(':POTypeID', $POTypeID)
                ->execute();
        return $this->redirect(['update', 'id' => $PRID]);
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        $type = empty($model['PRNum']) ? 'new' : 'edit';
        if ($model->load($post)) {
            $PRExtendedCost = TbPritemdetail2Temp::find()
                    ->where(['PRID' => $id])
                    ->sum('PRExtendedCost');

            $POPriceLimit = TbPotype::find()
                    ->where(['POTypeID' => $post['TbPr2Temp']['POTypeID']])
                    ->sum('POPriceLimit');

            if ((!empty($PRExtendedCost)) && (!empty($POPriceLimit)) && ($PRExtendedCost > $POPriceLimit)) {
                return 'เกินประเภทการสั่งซื้อ';
            } else if((TbPr2Temp::find()->where(['PRNum' => $post['TbPr2Temp']['PRNum']])->andWhere('PRID <> :PRID', [':PRID' => $id])->all()) != null || (TbPr2::find()->where(['PRNum' => $post['TbPr2Temp']['PRNum']])->andWhere('PRID <> :PRID', [':PRID' => $id])->all()) != null){
                return 'duplicate_prnum';
            }else {
                $PRID = !empty($post['TbPr2Temp']['PRID']) ? $post['TbPr2Temp']['PRID'] : NULL;
                $PRNum = $post['Auto-Gen'] == 'true' && $post['TbPr2Temp']['PRNum'] == 'Draft' ? Yii::$app->genprnum->generatePRNum(2) : $post['TbPr2Temp']['PRNum'];
                $PRDate = empty($post['TbPr2Temp']['PRDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbPr2Temp']['PRDate']);
                $PRTypeID = 2;
                $PRStatusID = 1;
                $DepartmentID = !empty($post['TbPr2Temp']['DepartmentID']) ? $post['TbPr2Temp']['DepartmentID'] : NULL;
                $SectionID = !empty($post['TbPr2Temp']['SectionID']) ? $post['TbPr2Temp']['SectionID'] : NULL;
                $POTypeID = !empty($post['TbPr2Temp']['POTypeID']) ? $post['TbPr2Temp']['POTypeID'] : NULL;
                $PRReasonNote = !empty($post['TbPr2Temp']['PRReasonNote']) ? $post['TbPr2Temp']['PRReasonNote'] : NULL;
                $PRExpectDate = !empty($post['TbPr2Temp']['PRExpectDate']) ? $post['TbPr2Temp']['PRExpectDate'] : NULL;
                $PRCreatedBy = Yii::$app->user->getId();
                $PRbudgetID = !empty($post['TbPr2Temp']['PRbudgetID']) ? $post['TbPr2Temp']['PRbudgetID'] : NULL;
                Yii::$app->db->createCommand('CALL cmd_pr2_savedraft(:PRDate,:PRTypeID,:PRStatusID,:DepartmentID,:SectionID,:POTypeID,:PRID,:PRReasonNote,:PRExpectDate,:PRCreatedBy,:PRbudgetID,:PRNum,:PRTotal);')
                        ->bindParam(':PRDate', $PRDate)
                        ->bindParam(':PRTypeID', $PRTypeID)
                        ->bindParam(':PRStatusID', $PRStatusID)
                        ->bindParam(':DepartmentID', $DepartmentID)
                        ->bindParam(':SectionID', $SectionID)
                        ->bindParam(':POTypeID', $POTypeID)
                        ->bindParam(':PRID', $PRID)
                        ->bindParam(':PRReasonNote', $PRReasonNote)
                        ->bindParam(':PRExpectDate', $PRExpectDate)
                        ->bindParam(':PRCreatedBy', $PRCreatedBy)
                        ->bindParam(':PRbudgetID', $PRbudgetID)
                        ->bindParam(':PRNum', $PRNum)
                        ->bindParam(':PRTotal', $PRExtendedCost)
                        ->execute();
                //$model = $this->findModel($PRID);
                TbPritemdetail2Temp::updateAll([
                    'PRNum' => $PRNum,
                        ], 'PRID = :PRID', [':PRID' => $id]);
                return $PRNum;
            }
        } else if ($type == 'new' || $type == 'view' || $type == 'edit') {
            $dataProvider = new ActiveDataProvider([
                'query' => TbPritemdetail2Temp::find()
                        ->select(['PRExtendedCost', 'ItemPackID', 'TMTID_TPU', 'ItemID', 'ItemName', 'ids', 'PRItemOnPCPlan', 'PROrderQty', 'PRUnitCost', 'PRExtendedCost'])
                        ->where(['PRID' => $id]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            $reason = $this->getReasonPR($id);


            return $this->render('update', [
                        'model' => $model,
                        'section' => $section,
                        //'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'reason' => $reason,
                        'type' => $type,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        $type = 'view';
        $dataProvider = new ActiveDataProvider([
            'query' => TbPritemdetail2Temp::find()
                    ->select(['TMTID_TPU', 'ItemName', 'ids', 'PRItemOnPCPlan', 'PROrderQty', 'PRUnitCost', 'PRExtendedCost'])
                    ->where(['PRID' => $id]),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);

        $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
        $reason = $this->getReasonPR($id);

        return $this->render('update', [
                    'model' => $model,
                    'section' => $section,
                    //'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'reason' => $reason,
                    'type' => $type,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteDetailtpu() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            TbPritemdetail2Temp::findOne($request->post('id'))->delete();
        }
    }

    protected function findModel($id) {
        if (($model = TbPr2Temp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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

    protected function getReasonPR($id) {
        $queryReason = TbPrReason::find()->where(['PRTypeID' => '2'])->orderBy('ids ASC')->all();
        $no = 1;
        $html = null;
        foreach ($queryReason as $reason) {
            $ReasonSelected = TbPrReasonselected::find()->where(['PRreasonID' => $reason['ids'], 'PRID' => $id])->all();
            if (empty($ReasonSelected)) {
                $options = '<label>' . Html::input('text', 'PRReason', $reason['ids'], ['type' => 'checkbox'])
                        . Html::tag('span', $no . '.' . ' ' . $reason['PRReason'], ['class' => 'text', 'style' => 'color:black;']) . '</label>';
                $html .= Html::tag('div', $options, ['class' => 'checkbox']);
                $no++;
            } else {
                $options = '<label>' . Html::input('text', 'PRReason', $reason['ids'], ['type' => 'checkbox', 'checked' => true])
                        . Html::tag('span', $no . '.' . ' ' . $reason['PRReason'], ['class' => 'text', 'style' => 'color:black;']) . '</label>';
                $html .= Html::tag('div', $options, ['class' => 'checkbox']);
                $no++;
            }
        };

        return $html;
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

    public function actionGetTableTpu() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $dataProvider = new ActiveDataProvider([
                'query' => VwItemListTpuplanAvalible::find()
                        ->select(['TMTID_TPU', 'ItemID', 'TMTID_GPU', 'FSN_TMT', 'PCPlanNum', 'TPUOrderQty', 'DispUnit', 'PRApprovedOrderQty', 'PRTPUAvalible']),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            $table = GridView::widget([
                        'dataProvider' => $dataProvider,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'bordered' => false,
                        'responsive' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT, 'id' => 'datatable-tpu', 'width' => '100%'],
                        'layout' => '{items}',
                        'columns' => [
                                [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '',
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                                [
                                'header' => 'รหัสยาการค้า',
                                'attribute' => 'TMTID_TPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->TMTID_TPU) ? '-' : $model->TMTID_TPU;
                                },
                            ],
                                [
                                'header' => 'รายละเอียดยา',
                                'attribute' => 'FSN_TMT',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model->FSN_TMT) ? '-' : $model->FSN_TMT;
                                },
                            ],
                                [
                                'header' => 'เลขที่แผนจัดซื้อ',
                                'attribute' => 'PCPlanNum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->PCPlanNum) ? '-' : $model->PCPlanNum;
                                },
                            ],
                                [
                                'header' => 'จำนวน',
                                'attribute' => 'TPUOrderQty',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model->TPUOrderQty) ? '' : $model->TPUOrderQty;
                                },
                            ],
                                [
                                'header' => 'หน่วย',
                                'attribute' => 'DispUnit',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model->DispUnit) ? '' : $model->DispUnit;
                                },
                            ],
                                [
                                'header' => 'ขอซื้อแล้ว',
                                'attribute' => 'PRApprovedOrderQty',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model->PRApprovedOrderQty) ? '' : $model->PRApprovedOrderQty;
                                },
                            ],
                                [
                                'header' => 'ขอซื้อได้',
                                'attribute' => 'PRTPUAvalible',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'contentOptions' => ['style' => 'text-align:right;'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model->PRTPUAvalible) ? '' : $model->PRTPUAvalible;
                                },
                            ],
                                [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Actions',
                                'noWrap' => true,
                                'hAlign' => GridView::ALIGN_CENTER,
                                'template' => '{select}',
                                'buttons' => [
                                    'select' => function ($url, $model, $key) {
                                        return Html::a('Select', false, [
                                                    'class' => 'btn btn-success btn-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Select',
                                                    'onclick' => 'SelectTPU(this);',
                                                    'data-id' => $model->PCPlanNum,
                                                    'id' => $model->TMTID_TPU,
                                                    'ItemID' => $model->ItemID,
                                                    'TMTID_GPU' => $model->TMTID_GPU,
                                        ]);
                                    },
                                ],
                            ],
                        ],
            ]);
            return $table;
        }
    }

    public function actionAddItemdetail() {
        $request = Yii::$app->request;
        $model = new TbPritemdetail2Temp();
        if ($request->isAjax) {
            $duplicate = $this->CheckDuplicate($request->post('tpu'), $request->post('PRID'), $request->post('plan'));
            if (!empty($duplicate)) {
                return 'false';
            }
            $itemList = VwItemListTpu::findOne(['TMTID_TPU' => $request->post('tpu'), 'ItemID' => $request->post('ItemID')]);
            $ItemPackUnit = $this->getItemPackUnit($request->post('GPU'), $request->post('ItemID'));

            return $this->renderAjax('_form_detailtpu', [
                        'model' => $model,
                        'ItemPackUnit' => $ItemPackUnit,
                        'itemList' => $itemList,
            ]);
        }
    }

    private function CheckDuplicate($tpu, $prid, $plan) {
        if (empty($plan)) {
            $Check = TbPritemdetail2Temp::findAll(['TMTID_TPU' => $tpu, 'PRID' => $prid]);
        } else {
            $Check = TbPritemdetail2Temp::findAll(['TMTID_TPU' => $tpu, 'PRID' => $prid, 'PCPlanNum' => $plan]);
        }
        return $Check;
    }

    private function getItemPackUnit($GPU, $ItemID) {
        $query = TbItempack::find()->where(['TMTID_GPU' => $GPU, 'ItemID' => $ItemID])->all();
        foreach ($query as $d) {
            $result[] = $d['ItemPackUnit'];
        }
        return empty($result) ? null : $result;
    }

    public function actionGetDatapcplan() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = VwTpuplanDetailAvalible::findOne([
                        'TMTID_TPU' => $request->post('TMTID_TPU'),
                        'PCPlanNum' => $request->post('PCPlanNum'),
            ]);
            $arr = array(
                'FSN_TMT' => $query['FSN_TMT'],
                'GPUStdCost' => empty($query['GPUStdCost']) ? null : number_format($query['GPUStdCost'], 4),
                'TPUUnitCost' => empty($query['TPUUnitCost']) ? null : number_format($query['TPUUnitCost'], 4),
                'TPUOrderQty' => empty($query['TPUOrderQty']) ? null : number_format($query['TPUOrderQty'], 4),
                'PRApprovedOrderQty' => empty($query['PRApprovedOrderQty']) ? null : number_format($query['PRApprovedOrderQty'], 4),
                'PRTPUAvalible' => empty($query['PRTPUAvalible']) ? null : number_format($query['PRTPUAvalible'], 4),
            );
            return $arr;
        }
    }

    public function actionGetSkuqty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($post['Type'] == 'OnChange') {
                $query = TbItempack::findOne([
                            'ItemID' => $post['ItemID'],
                            'TMTID_GPU' => $post['TMTID_GPU'],
                            'ItemPackUnit' => $post['ItemPackUnit'],
                ]);
                $PROrderQty = $post['PRPackQty'] * $query['ItemPackSKUQty']; //คำนวณขอซื้อ
                $PRUnitCost = $post['ItemPackCost'] / $query['ItemPackSKUQty'];
                $Total = $PROrderQty * number_format($PRUnitCost, 4);
                $arr = array(
                    'ItemPackSKUQty' => number_format($query['ItemPackSKUQty'], 4),
                    'PROrderQty' => $PROrderQty,
                    'PRUnitCost' => $PRUnitCost,
                    'Total' => $Total,
                    'ItemPackID' => $query['ItemPackID'],
                );
                return $arr;
            } elseif ($post['Type'] == 'OnEdit') {
                $query = TbItempack::findOne($post['PackID']);
                $arr = array(
                    'ItemPackSKUQty' => number_format($query['ItemPackSKUQty'], 4),
                    'ItemPackUnit' => $query['ItemPackUnit'],
                );
                return $arr;
            }
        }
    }

    public function actionSaveItemdetails() {
        $request = Yii::$app->request->post();
        if ($request) {

            $cmd = null;
            $ItemID = !empty($request['TbPritemdetail2Temp']['ItemID']) ? $request['TbPritemdetail2Temp']['ItemID'] : NULL;
            $TMTID_GPU = !empty($request['TbPritemdetail2Temp']['TMTID_GPU']) ? $request['TbPritemdetail2Temp']['TMTID_GPU'] : NULL;
            $TMTID_TPU = !empty($request['TbPritemdetail2Temp']['TMTID_TPU']) ? $request['TbPritemdetail2Temp']['TMTID_TPU'] : NULL;
            $ItemName = !empty($request['TbPritemdetail2Temp']['ItemName']) ? $request['TbPritemdetail2Temp']['ItemName'] : NULL;
            $PCPlanNum = !empty($request['TbPritemdetail2Temp']['PCPlanNum']) ? $request['TbPritemdetail2Temp']['PCPlanNum'] : NULL;
            $PRItemStdCost = !empty($request['TbPritemdetail2Temp']['PRItemStdCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRItemStdCost']) : NULL;
            $PRItemUnitCost = !empty($request['TbPritemdetail2Temp']['PRItemUnitCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRItemUnitCost']) : NULL;
            $PRItemOrderQty = !empty($request['TbPritemdetail2Temp']['PRItemOrderQty']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRItemOrderQty']) : NULL;
            $PRApprovedOrderQtySum = !empty($request['TbPritemdetail2Temp']['PRApprovedOrderQtySum']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRApprovedOrderQtySum']) : NULL;
            $PRItemAvalible = !empty($request['TbPritemdetail2Temp']['PRItemAvalible']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRItemAvalible']) : NULL;
            $PRExtendedCost = !empty($request['TbPritemdetail2Temp']['PRExtendedCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRExtendedCost']) : NULL;
            $PROrderQty = !empty($request['TbPritemdetail2Temp']['PROrderQty']) ? $this->strNumber($request['TbPritemdetail2Temp']['PROrderQty']) : NULL;
            $PRUnitCost = !empty($request['TbPritemdetail2Temp']['PRUnitCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRUnitCost']) : NULL;
            $PRPackQty = !empty($request['TbPritemdetail2Temp']['PRPackQty']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRPackQty']) : NULL;
            $PackID = !empty($request['TbPritemdetail2Temp']['PackID']) ? $request['TbPritemdetail2Temp']['PackID'] : NULL;
            $ItemPackCost = !empty($request['TbPritemdetail2Temp']['ItemPackCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['ItemPackCost']) : NULL;
            $ids_PR_selected = NULL;
            $PRID = !empty($request['TbPritemdetail2Temp']['PRID']) ? $request['TbPritemdetail2Temp']['PRID'] : NULL;
            $ids = !empty($request['TbPritemdetail2Temp']['ids']) ? $request['TbPritemdetail2Temp']['ids'] : TbPritemdetail2Temp::find()->max('ids') + 1;
            $PRCreatedBy = Yii::$app->user->getId();
            $PRLastUnitCost = !empty($request['TbPritemdetail2Temp']['PRLastUnitCost']) ? $this->strNumber($request['TbPritemdetail2Temp']['PRLastUnitCost']) : NULL;
            $PRItemOnPCPlan = !empty($request['TbPritemdetail2Temp']['PRItemOnPCPlan']) ? $request['TbPritemdetail2Temp']['PRItemOnPCPlan'] : 8;

            if (!empty($PCPlanNum) && ($request['formsubmit'] != 'pass')) {
                return $this->CheckOverPlan($PRItemStdCost, $PRItemUnitCost, $PRUnitCost, $PRItemAvalible, $PROrderQty);
            } else {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    Yii::$app->db->createCommand('
                    CALL cmd_pr2_item_save(
                    :cmd,
                    :PCPlanNum,
                    :ItemID,
                    :TMTID_GPU,
                    :TMTID_TPU,
                    :ItemName,
                    :PRItemStdCost,
                    :PRItemUnitCost,
                    :PRItemOrderQty,
                    :PRApprovedOrderQtySum,
                    :PRItemAvalible,
                    :PRUnitCost,
                    :PROrderQty,
                    :PRExtendedCost,
                    :PRPackQty,
                    :ItemPackID,
                    :ItemPackCost,
                    :ids_PR_selected,
                    :PRID,
                    :ids,
                    :PRCreatedBy,
                    :PRLastUnitCost,
                    :PRItemOnPCPlan
                    );')
                            ->bindParam(':cmd', $cmd)
                            ->bindParam(':PCPlanNum', $PCPlanNum)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->bindParam(':TMTID_TPU', $TMTID_TPU)
                            ->bindParam(':ItemName', $ItemName)
                            ->bindParam(':PRItemStdCost', $PRItemStdCost)
                            ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                            ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                            ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                            ->bindParam(':PRItemAvalible', $PRItemAvalible)
                            ->bindParam(':PRUnitCost', $PRUnitCost)
                            ->bindParam(':PROrderQty', $PROrderQty)
                            ->bindParam(':PRExtendedCost', $PRExtendedCost)
                            ->bindParam(':PRPackQty', $PRPackQty)
                            ->bindParam(':ItemPackID', $PackID)
                            ->bindParam(':ItemPackCost', $ItemPackCost)
                            ->bindParam(':ids_PR_selected', $ids_PR_selected)
                            ->bindParam(':PRID', $PRID)
                            ->bindParam(':ids', $ids)
                            ->bindParam(':PRCreatedBy', $PRCreatedBy)
                            ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                            ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
                            ->execute();
                    $transaction->commit();
                    return 'save';
                } catch (StaleObjectException $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
    }

    private function strNumber($number) {
        if (!empty($number)) {
            return str_replace(',', '', $number);
        } else {
            return NULL;
        }
    }

    private function CheckOverPlan($PRItemStdCost, $PRItemUnitCost, $PRUnitCost, $PRItemAvalible, $PROrderQty) {

        $STD = $this->CheckOverStd($PRUnitCost, $PRItemStdCost);
        $Unicost = $this->CheckOverUnicost($PRUnitCost, $PRItemUnitCost);
        $Qty = $this->CheckOverQty($PROrderQty, $PRItemAvalible);

        #ราคากลางเกินราคากลาง
        if (($STD == 'StdOver') && ($Unicost == 'UnicostNotOver') && ($Qty == 'QtyNotOver')) {
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p>';
            #ราคาต่อหน่วยเกินราคาต่อหน่วย
        } else if (($STD == 'StdNotOver') && ($Unicost == 'UnicostOver') && ($Qty == 'QtyNotOver')) {
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>';
            #ปริมาณขอซื้อเกิน
        } else if (($STD == 'StdNotOver') && ($Unicost == 'UnicostNotOver') && ($Qty == 'QtyOver')) {
            return '<p style="color:#DD6B55;">1.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>';
            #เกินทุกราคา
        } else if (($STD == 'StdOver') && ($Unicost == 'UnicostOver') && ($Qty == 'QtyOver')) {
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">3.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>';
            #ราคาต่อหน่วยเกินราคากลาง และ ราคาต่อหน่วยเกินราคาต่อหน่วย
        } else if (($STD == 'StdOver') && ($Unicost == 'UnicostOver') && ($Qty == 'QtyNotOver')) {
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>';
            #ราคากลางเกินราคาต่อหน่วย และ ปริมาณขอซื้อเกิน
        } else if (($STD == 'StdOver') && ($Unicost == 'UnicostNotOver') && ($Qty == 'QtyOver')) {
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>';
        } else if (($STD == 'StdNotOver') && ($Unicost == 'UnicostOver') && ($Qty == 'QtyOver')) {
            #ราคาต่อหน่วยและปริมาณขอซิ้อเกิน
            return '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>';
        } else {
            return 'pass';
        }
    }

    private function CheckOverStd($PRUnitCost, $PRItemStdCost) {
        if ($PRUnitCost != null && $PRItemStdCost != null) {
            if (($PRUnitCost > $PRItemStdCost)) {
                return 'StdOver';
            } else {
                return 'StdNotOver';
            }
        } else {
            return 'StdNotOver';
        }
    }

    private function CheckOverUnicost($PRUnitCost, $PRItemUnitCost) {
        if ($PRUnitCost != null && $PRItemUnitCost != null) {
            if (($PRUnitCost > $PRItemUnitCost)) {
                return 'UnicostOver';
            } else {
                return 'UnicostNotOver';
            }
        } else {
            return 'UnicostNotOver';
        }
    }

    private function CheckOverQty($PROrderQty, $PRItemAvalible) {
        if ($PROrderQty != null && $PRItemAvalible != null) {
            if (($PROrderQty > $PRItemAvalible)) {
                return 'QtyOver';
            } else {
                return 'QtyNotOver';
            }
        } else {
            return 'QtyNotOver';
        }
    }

    public function actionUpdateDetailtpu($id) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $model = TbPritemdetail2Temp::findOne($id);
            $itemList = VwItemListTpu::findOne(['TMTID_TPU' => $model['TMTID_TPU'], 'ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['TMTID_GPU'], $model['ItemID']);

            return $this->renderAjax('_form_detailtpu', [
                        'model' => $model,
                        'ItemPackUnit' => $ItemPackUnit,
                        'itemList' => $itemList,
            ]);
        }
    }

    public function actionSaveReason() {
        $request = Yii::$app->request->post();
        if ($request) {
            $find = TbPrReasonselected::findOne(['PRID' => $request['PRID']]);
            if ($find !== null) {
                TbPrReasonselected::deleteAll(['PRID' => $request['PRID']]);
            }
            if (isset($request['reasonid'])) {
                foreach ($request['reasonid'] as $value) {
                    $modelReason = new TbPrReasonselected();
                    $modelReason->PRID = $request['PRID'];
                    $modelReason->PRreasonID = $value;
                    $modelReason->PRreasonIDStatus = 1;
                    $modelReason->save();
                }
            }
        }
    }

    public function actionClearTempgpu() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $this->findModel($request->post('id'))->delete();
            TbPritemdetail2Temp::deleteAll(['PRID' => $request->post('id')]);
            TbPrReasonselected::deleteAll(['PRID' => $request->post('id')]);
            Yii::$app->session->setFlash('success', 'Clear Success!');
            return $this->redirect(['/pr/default/index']);
        } else {
            return false;
        }
    }

    public function actionSendtoverify() {
        $request = Yii::$app->request->post();
        if ($request) {
            $PRID = $request['PRID'];
            $model  = TbPr2Temp::findOne($PRID);
            TbPritemdetail2Temp::updateAll([
                    'PRNum' => $model['PRNum'],
                        ], 'PRID = :PRID', [':PRID' => $PRID]);
            Yii::$app->db->createCommand('CALL cmd_pr2_send_to_verify(:x);')
                    ->bindParam(':x', $PRID)
                    ->execute();

            TbPr2Temp::findOne($PRID)->delete();
            TbPritemdetail2Temp::deleteAll(['PRID' => $PRID]);
            Yii::$app->session->setFlash('success', 'Send ' . $request['PRNum'] . ' To Verify Success!');
            return $this->redirect(['/pr/default/index']);
        }
    }

    public function actionVerifyPr($data) {
        if (($model = TbPr2::findOne($data)) !== null) {
            $type = 'verify';
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            $reason = $this->getReasonLabel($data);
            $dataProvider = new ActiveDataProvider([
                'query' => TbPritemdetail2::find()
                        ->select(['TMTID_TPU', 'PRExtendedCost', 'PRItemOnPCPlan', 'ids', 'ItemID', 'ItemName', 'PROrderQty', 'PRUnitCost', 'PRVerifyQty', 'PRVerifyUnitCost', 'ItemPackID', 'ItemPackIDVerify'])
                        ->where(['PRID' => $data]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->render('_form_verify', [
                        'model' => $model,
                        'section' => $section,
                        'reason' => $reason,
                        'type' => $type,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getReasonLabel($id) {
        $ReasonSelected = TbPrReasonselected::find()->where(['PRID' => $id])->all();
        if ($ReasonSelected != null) {
            $no = 1;
            $html = '<div>';
            foreach ($ReasonSelected as $reason) {
                $queryReason = TbPrReason::find()->where(['PRTypeID' => '2', 'ids' => $reason['PRreasonID']])->orderBy('ids ASC')->one();
                if ($queryReason != null) {
                    $html .= '<div class="checkbox"><label>';
                    $html .= '<span class="text">' . $no . '.' . $queryReason['PRReason'] . '</span>'
                            . '</label>'
                            . '</div>';
                    $no++;
                }
            }
            $html .= '</div>';
        } else {
            $html = '<label>ไม่ได้ระบุ</label>';
        }

        return $html;
    }

    public function actionOkVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPritemdetail2::findOne($request->post('id'));
            $model->PRPackQtyVerify = $model->PRPackQty;
            $model->ItemPackIDVerify = $model->ItemPackID;
            $model->ItemPackCostVerify = $model->ItemPackCost;
            $model->PRVerifyQty = $model->PROrderQty;
            $model->PRVerifyUnitCost = $model->PRUnitCost;
            $model->PRItemNumStatusID = 2;
            $model->save();
            return 'OK Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCancelVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPritemdetail2::findOne($request->post('id'));
            $model->PRPackQtyVerify = null;
            $model->ItemPackIDVerify = null;
            $model->ItemPackCostVerify = null;
            $model->PRVerifyQty = null;
            $model->PRVerifyUnitCost = null;
            $model->PRItemNumStatusID = 1;
            $model->save();
            return 'Cancel Complete!';
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateVerify($id) {
        $request = Yii::$app->request;
        if (($model = TbPritemdetail2::findOne($id)) !== null && $request->isGet) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $itemList = VwItemListTpu::findOne(['TMTID_TPU' => $model['TMTID_TPU'], 'ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['TMTID_GPU'], $model['ItemID']);
            return $this->renderAjax('_form_detail_verify', [
                        'model' => $model,
                        'ItemPackUnit' => $ItemPackUnit,
                        'itemList' => $itemList,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSaveitemDetailsVerify() {
        $request = Yii::$app->request->post();
        if ($request) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $PCPlanNum = !empty($request['TbPritemdetail2']['PCPlanNum']) ? $request['TbPritemdetail2']['PCPlanNum'] : NULL;
                $PRItemStdCost = !empty($request['TbPritemdetail2']['PRItemStdCost']) ? $this->strNumber($request['TbPritemdetail2']['PRItemStdCost']) : NULL;
                $PRItemUnitCost = !empty($request['TbPritemdetail2']['PRItemUnitCost']) ? $this->strNumber($request['TbPritemdetail2']['PRItemUnitCost']) : NULL;
                $PRItemOrderQty = !empty($request['TbPritemdetail2']['PRItemOrderQty']) ? $this->strNumber($request['TbPritemdetail2']['PRItemOrderQty']) : NULL;
                $PRItemAvalible = !empty($request['TbPritemdetail2']['PRItemAvalible']) ? $this->strNumber($request['TbPritemdetail2']['PRItemAvalible']) : NULL;
                $PROrderQty = !empty($request['TbPritemdetail2']['PROrderQty']) ? $this->strNumber($request['TbPritemdetail2']['PROrderQty']) : NULL;
                $PRUnitCost = !empty($request['TbPritemdetail2']['PRUnitCost']) ? $this->strNumber($request['TbPritemdetail2']['PRUnitCost']) : NULL;
                $PRPackQty = !empty($request['TbPritemdetail2']['PRPackQty']) ? $this->strNumber($request['TbPritemdetail2']['PRPackQty']) : NULL;
                $PackID = !empty($request['TbPritemdetail2']['PackID']) ? $request['TbPritemdetail2']['PackID'] : NULL;
                $PRItemOnPCPlan = !empty($request['TbPritemdetail2']['PRItemOnPCPlan']) ? $request['TbPritemdetail2']['PRItemOnPCPlan'] : 8;
                $ItemPackCost = !empty($request['TbPritemdetail2']['ItemPackCost']) ? $this->strNumber($request['TbPritemdetail2']['ItemPackCost']) : NULL;
                $PRExtendedCost = !empty($request['TbPritemdetail2']['PRExtendedCost']) ? $this->strNumber($request['TbPritemdetail2']['PRExtendedCost']) : NULL;

                if (!empty($PCPlanNum) && ($request['formsubmit'] != 'pass')) {
                    return $this->CheckOverPlan($PRItemStdCost, $PRItemUnitCost, $PRUnitCost, $PRItemAvalible, $PROrderQty);
                } else {
                    $model = TbPritemdetail2::findOne($request['TbPritemdetail2']['ids']);
                    $model->PRPackQtyVerify = $PRPackQty;
                    $model->ItemPackIDVerify = $PackID;
                    $model->ItemPackCostVerify = $ItemPackCost;
                    $model->PRVerifyQty = $PROrderQty;
                    $model->PRVerifyUnitCost = $PRUnitCost;
                    $model->PRItemOnPCPlan = $PRItemOnPCPlan;
                    $model->PRExtendedCost = $PRExtendedCost;
                    $model->PRItemNumStatusID = 2;
                    $model->save();
                    $transaction->commit();
                    return 'save';
                }
            } catch (StaleObjectException $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

    public function actionRejectedVerify() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPr2::findOne($request->post('PRID'));
            $model->PRStatusID = 4;
            $model->PRRejectReason = $request->post('PRRejectReason');
            $model->PRRejectTime = date('H:i:s');
            $model->PRRejectDate = date('Y-m-d');
            $model->save();

            TbPritemdetail2::updateAll([
                'PRPackQtyVerify' => null,
                'ItemPackIDVerify' => null,
                'ItemPackCostVerify' => null,
                'PRVerifyQty' => null,
                'PRVerifyUnitCost' => null,
                'PRItemNumStatusID' => 1,
                    ], 'PRID = :PRID', [':PRID' => $request->post('PRID')]);
            Yii::$app->session->setFlash('success', 'Reject ' . $model['PRNum'] . ' Success!');
            return $this->redirect('/km4/pr/default/list-verify');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateRejectVerify($data) {
        $post = Yii::$app->request->post();
        if (($model = TbPr2::findOne($data)) !== null) {
            $type = 'edit';
            if ($model->load($post)) {
                $PRExtendedCost = TbPritemdetail2::find()
                        ->where(['PRID' => $post['TbPr2']['PRID']])
                        ->sum('PRExtendedCost');

                $POPriceLimit = TbPotype::find()
                        ->where(['POTypeID' => $post['TbPr2']['POTypeID']])
                        ->sum('POPriceLimit');

                if ((!empty($PRExtendedCost)) && (!empty($POPriceLimit)) && ($PRExtendedCost > $POPriceLimit)) {
                    return 'เกินประเภทการสั่งซื้อ';
                } else {
                    $model->PRDate = empty($post['TbPr2']['PRDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbPr2']['PRDate']);
                    $model->PRTypeID = 2;
                    $model->PRStatusID = 4;
                    $model->DepartmentID = !empty($post['TbPr2']['DepartmentID']) ? $post['TbPr2']['DepartmentID'] : NULL;
                    $model->SectionID = !empty($post['TbPr2']['SectionID']) ? $post['TbPr2']['SectionID'] : NULL;
                    $model->POTypeID = !empty($post['TbPr2']['POTypeID']) ? $post['TbPr2']['POTypeID'] : NULL;
                    $model->PRReasonNote = !empty($post['TbPr2']['PRReasonNote']) ? $post['TbPr2']['PRReasonNote'] : NULL;
                    $model->PRExpectDate = !empty($post['TbPr2']['PRExpectDate']) ? $post['TbPr2']['PRExpectDate'] : NULL;
                    $model->PRbudgetID = !empty($post['TbPr2']['PRbudgetID']) ? $post['TbPr2']['PRbudgetID'] : NULL;
                    $model->save();
                    TbPritemdetail2::updateAll([
                    'PRNum' => $post['TbPr2']['PRNum'],
                        ], 'PRID = :PRID', [':PRID' => $data]);
                    return 'success';
                }
            } else if ($type == 'edit' || $type == 'view') {
                $dataProvider = new ActiveDataProvider([
                    'query' => TbPritemdetail2::find()
                            ->select(['TMTID_TPU', 'ItemName', 'ids', 'PRItemOnPCPlan', 'PROrderQty', 'PRUnitCost', 'PRExtendedCost'])
                            ->where(['PRID' => $data]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
                $reason = $this->getReasonPR($data);

                return $this->render('update-reject-verify', [
                            'model' => $model,
                            'section' => $section,
                            'dataProvider' => $dataProvider,
                            'reason' => $reason,
                            'type' => $type,
                ]);
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddItemdetailReject() {
        $request = Yii::$app->request;
        $model = new TbPritemdetail2();
        if ($request->isAjax) {
            $duplicate = $this->CheckDuplicateReject($request->post('tpu'), $request->post('PRID'), $request->post('plan'));
            if (!empty($duplicate)) {
                return 'false';
            }
            $itemList = VwItemListTpu::findOne(['TMTID_TPU' => $request->post('tpu'), 'ItemID' => $request->post('ItemID')]);
            $ItemPackUnit = $this->getItemPackUnit($request->post('GPU'), $request->post('ItemID'));

            return $this->renderAjax('_form_detail_reject', [
                        'model' => $model,
                        'ItemPackUnit' => $ItemPackUnit,
                        'itemList' => $itemList,
            ]);
        }
    }

    private function CheckDuplicateReject($TMTID_TPU, $prid, $plan) {
        if (empty($plan)) {
            $Check = TbPritemdetail2::findAll(['TMTID_TPU' => $TMTID_TPU, 'PRID' => $prid]);
        } else {
            $Check = TbPritemdetail2::findAll(['TMTID_TPU' => $TMTID_TPU, 'PRID' => $prid, 'PCPlanNum' => $plan]);
        }
        return $Check;
    }

    public function actionSaveItemdetailsReject() {
        $request = Yii::$app->request->post();
        if ($request) {
            $ItemID = !empty($request['TbPritemdetail2']['ItemID']) ? $request['TbPritemdetail2']['ItemID'] : NULL;
            $TMTID_GPU = !empty($request['TbPritemdetail2']['TMTID_GPU']) ? $request['TbPritemdetail2']['TMTID_GPU'] : NULL;
            $TMTID_TPU = !empty($request['TbPritemdetail2']['TMTID_TPU']) ? $request['TbPritemdetail2']['TMTID_TPU'] : NULL;
            $ItemName = !empty($request['TbPritemdetail2']['ItemName']) ? $request['TbPritemdetail2']['ItemName'] : NULL;
            $PCPlanNum = !empty($request['TbPritemdetail2']['PCPlanNum']) ? $request['TbPritemdetail2']['PCPlanNum'] : NULL;
            $PRItemStdCost = !empty($request['TbPritemdetail2']['PRItemStdCost']) ? $this->strNumber($request['TbPritemdetail2']['PRItemStdCost']) : NULL;
            $PRItemUnitCost = !empty($request['TbPritemdetail2']['PRItemUnitCost']) ? $this->strNumber($request['TbPritemdetail2']['PRItemUnitCost']) : NULL;
            $PRItemOrderQty = !empty($request['TbPritemdetail2']['PRItemOrderQty']) ? $this->strNumber($request['TbPritemdetail2']['PRItemOrderQty']) : NULL;
            $PRApprovedOrderQtySum = !empty($request['TbPritemdetail2']['PRApprovedOrderQtySum']) ? $this->strNumber($request['TbPritemdetail2']['PRApprovedOrderQtySum']) : NULL;
            $PRItemAvalible = !empty($request['TbPritemdetail2']['PRItemAvalible']) ? $this->strNumber($request['TbPritemdetail2']['PRItemAvalible']) : NULL;
            $PRExtendedCost = !empty($request['TbPritemdetail2']['PRExtendedCost']) ? $this->strNumber($request['TbPritemdetail2']['PRExtendedCost']) : NULL;
            $PROrderQty = !empty($request['TbPritemdetail2']['PROrderQty']) ? $this->strNumber($request['TbPritemdetail2']['PROrderQty']) : NULL;
            $PRUnitCost = !empty($request['TbPritemdetail2']['PRUnitCost']) ? $this->strNumber($request['TbPritemdetail2']['PRUnitCost']) : NULL;
            $PRPackQty = !empty($request['TbPritemdetail2']['PRPackQty']) ? $this->strNumber($request['TbPritemdetail2']['PRPackQty']) : NULL;
            $PackID = !empty($request['TbPritemdetail2']['PackID']) ? $request['TbPritemdetail2']['PackID'] : NULL;
            $ItemPackCost = !empty($request['TbPritemdetail2']['ItemPackCost']) ? $this->strNumber($request['TbPritemdetail2']['ItemPackCost']) : NULL;
            $PRID = !empty($request['TbPritemdetail2']['PRID']) ? $request['TbPritemdetail2']['PRID'] : NULL;
            $ids = !empty($request['TbPritemdetail2']['ids']) ? $request['TbPritemdetail2']['ids'] : TbPritemdetail2::find()->max('ids') + 1;
            $PRCreatedBy = Yii::$app->user->getId();
            $PRLastUnitCost = !empty($request['TbPritemdetail2']['PRLastUnitCost']) ? $this->strNumber($request['TbPritemdetail2']['PRLastUnitCost']) : NULL;
            $PRItemOnPCPlan = !empty($request['TbPritemdetail2']['PRItemOnPCPlan']) ? $request['TbPritemdetail2']['PRItemOnPCPlan'] : 8;
            if (!empty($PCPlanNum) && ($request['formsubmit'] != 'pass')) {
                return $this->CheckOverPlan($PRItemStdCost, $PRItemUnitCost, $PRUnitCost, $PRItemAvalible, $PROrderQty);
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    Yii::$app->db->createCommand('CALL cmd_pr2_item_save_reject('
                                    . ':ids,:PCPlanNum,:ItemID,:TMTID_GPU,:TMTID_TPU,:ItemName,:PRItemStdCost,:PRItemUnitCost'
                                    . ',:PRItemOrderQty,:PRApprovedOrderQtySum,:PRItemAvalible,:PRLastUnitCost,:PRPackQty,:ItemPackID,:ItemPackCost'
                                    . ',:PROrderQty,:PRUnitCost,:PRExtendedCost,:PRID,:PRCreatedBy,:PRItemOnPCPlan);')
                            ->bindParam(':ids', $ids)
                            ->bindParam(':PCPlanNum', $PCPlanNum)
                            ->bindParam(':ItemID', $ItemID)
                            ->bindParam(':TMTID_GPU', $TMTID_GPU)
                            ->bindParam(':TMTID_TPU', $TMTID_TPU)
                            ->bindParam(':ItemName', $ItemName)
                            ->bindParam(':PRItemStdCost', $PRItemStdCost)
                            ->bindParam(':PRItemUnitCost', $PRItemUnitCost)
                            ->bindParam(':PRItemOrderQty', $PRItemOrderQty)
                            ->bindParam(':PRApprovedOrderQtySum', $PRApprovedOrderQtySum)
                            ->bindParam(':PRItemAvalible', $PRItemAvalible)
                            ->bindParam(':PRLastUnitCost', $PRLastUnitCost)
                            ->bindParam(':PRPackQty', $PRPackQty)
                            ->bindParam(':ItemPackID', $PackID)
                            ->bindParam(':ItemPackCost', $ItemPackCost)
                            ->bindParam(':PROrderQty', $PROrderQty)
                            ->bindParam(':PRUnitCost', $PRUnitCost)
                            ->bindParam(':PRExtendedCost', $PRExtendedCost)
                            ->bindParam(':PRID', $PRID)
                            ->bindParam(':PRCreatedBy', $PRCreatedBy)
                            ->bindParam(':PRItemOnPCPlan', $PRItemOnPCPlan)
                            ->execute();
                    $transaction->commit();
                    return 'save';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
    }

    public function actionUpdateDetailReject($id) {
        $request = Yii::$app->request;
        if ($request->isGet) {
            $model = TbPritemdetail2::findOne($id);
            $itemList = VwItemListTpu::findOne(['TMTID_TPU' => $model['TMTID_TPU'], 'ItemID' => $model['ItemID']]);
            $ItemPackUnit = $this->getItemPackUnit($model['TMTID_GPU'], $model['ItemID']);

            return $this->renderAjax('_form_detail_reject', [
                        'model' => $model,
                        'ItemPackUnit' => $ItemPackUnit,
                        'itemList' => $itemList,
            ]);
        }
    }

    public function actionDeleteDetailReject() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            TbPritemdetail2::findOne($request->post('id'))->delete();
        }
    }

    public function actionSendtoverifyReject() {
        $request = Yii::$app->request->post();
        if ($request) {
            $model = TbPr2::findOne($request['PRID']);
            $model->PRStatusID = 2;
            $model->save();
            TbPritemdetail2::updateAll([
                'PRItemNumStatusID' => 1,
                'PRNum' => $model['PRNum'],
                    ], 'PRID = :PRID', [':PRID' => $request['PRID']]);
            Yii::$app->session->setFlash('success', 'Send ' . $request['PRNum'] . ' To Verify Success!');
            return $this->redirect(['/pr/default/reject-verify']);
        }
    }

    public function actionViewVerify($data) {
        if (($model = TbPr2::findOne($data)) !== null) {
            $type = 'view';
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            $reason = $this->getReasonLabel($data);
            $dataProvider = new ActiveDataProvider([
                'query' => TbPritemdetail2::find()
                        ->select(['TMTID_TPU', 'PRExtendedCost', 'PRItemOnPCPlan', 'ids', 'ItemID', 'ItemName', 'PROrderQty', 'PRUnitCost', 'PRVerifyQty', 'PRVerifyUnitCost', 'ItemPackID', 'ItemPackIDVerify'])
                        ->where(['PRID' => $data]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->render('_form_verify', [
                        'model' => $model,
                        'section' => $section,
                        'reason' => $reason,
                        'type' => $type,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewRejectVerify($data) {
        if (($model = TbPr2::findOne($data)) !== null) {
            $type = 'view';
            $dataProvider = new ActiveDataProvider([
                'query' => TbPritemdetail2::find()
                        ->select(['TMTID_TPU', 'ItemName', 'ids', 'PRItemOnPCPlan', 'PROrderQty', 'PRUnitCost', 'PRExtendedCost'])
                        ->where(['PRID' => $data]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            $reason = $this->getReasonPR($data);

            return $this->render('update-reject-verify', [
                        'model' => $model,
                        'section' => $section,
                        'dataProvider' => $dataProvider,
                        'reason' => $reason,
                        'type' => $type,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSavedraftVerify() {
        $request = Yii::$app->request->post();
        if ($request) {
            $model = TbPr2::findOne($request['TbPr2']['PRID']);
            $model->PRVerifyNote = empty($request['TbPr2']['PRVerifyNote']) ? null : $request['TbPr2']['PRVerifyNote'];
            $model->PRStatusID = 2;
            $model->PRbudgetID = empty($request['TbPr2']['PRbudgetID']) ? null : $request['TbPr2']['PRbudgetID'];
            $model->save();
            return 'success';
        } else {
            throw new NotFoundHttpException('error.');
        }
    }

    public function actionVerifyApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ((TbPritemdetail2::find()->where(['PRVerifyQty' => null, 'PRID' => $request->post('PRID')])->all()) != null) {
                return 'มี ' . TbPritemdetail2::find()->where(['PRVerifyQty' => null, 'PRID' => $request->post('PRID')])->count('ids') . ' รายการ ที่ยังไม่ได้ถูก Update หรือ ยืนยัน';
            } else {
                return 'Pass';
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAutoApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $PRExtendedCost = TbPritemdetail2::find()
                    ->where(['PRID' => $request->post('PRID'), 'PRItemNumStatusID' => 2])
                    ->sum('PRExtendedCost');
            $modelPR = TbPr2::findOne($request->post('PRID'));
            $modelPR->PRStatusID = 11;
            $modelPR->PRApprovaDate = date('Y-m-d');
            $modelPR->PRApprovatime = date('H:i:s');
            $modelPR->PRTotal = number_format($PRExtendedCost, 2);
            $modelPR->PRVerifyBy = \Yii::$app->user->getId();
            $modelPR->PRApproveBy = Yii::$app->user->getId();
            $modelPR->save();

            $sql = "
                 UPDATE tb_pritemdetail2
                    SET PRPackQtyApprove = PRPackQtyVerify,
                     ItemPackCostApprove = ItemPackCostVerify,
                     PRApprovedUnitCost = PRVerifyUnitCost,
                     PRApprovedOrderQty = PRVerifyQty,
                     ItemPackIDApprove = ItemPackIDVerify
                    WHERE
                            PRID = $modelPR->PRID;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
            Yii::$app->session->setFlash('success', 'Send ' . $modelPR['PRNum'] . ' To Approve Success!');
            return $this->redirect('/km4/pr/default/list-verify');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprovePr($data) {
        if (($model = TbPr2::findOne($data)) !== null) {
            $type = null;
            if ($model['PRStatusID'] == '10' && \Yii::$app->user->can('ApprovePR', ['model' => $model])) {
                $type = 'approve';
            } elseif ($model['PRStatusID'] == '10') {
                $type = 'view';
            } elseif ($model['PRStatusID'] == '6') {
                $type = 'reject';
            } elseif ($model['PRStatusID'] == '11') {
                $type = 'approve';
            }
            $section = ArrayHelper::map($this->getSection($model->DepartmentID), 'id', 'name');
            $reason = $this->getReasonLabel($data);
            $dataProvider = new ActiveDataProvider([
                'query' => TbPritemdetail2::find()
                        ->select(['PRExtendedCost', 'PRItemOnPCPlan', 'ids', 'ItemID', 'ItemName', 'PROrderQty', 'PRUnitCost', 'PRVerifyQty', 'PRVerifyUnitCost', 'ItemPackID', 'ItemPackIDVerify'])
                        ->where(['PRID' => $data]),
                'pagination' => [
                    'pageSize' => false,
                ],
            ]);
            return $this->render('_form_approve', [
                        'model' => $model,
                        'section' => $section,
                        'reason' => $reason,
                        'type' => $type,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRejectedApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPr2::findOne($request->post('PRID'));
            $model->PRStatusID = 6;
            $model->PRRejectReason = $request->post('PRRejectReason');
            $model->PRRejectTime = date('H:i:s');
            $model->PRRejectDate = date('Y-m-d');
            $model->save();
            Yii::$app->session->setFlash('success', 'Reject ' . $model['PRNum'] . ' Success!');
            return $this->redirect('/km4/pr/default/list-approve');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprove() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $PRExtendedCost = TbPritemdetail2::find()
                    ->where(['PRID' => $request->post('PRID'), 'PRItemNumStatusID' => 2])
                    ->sum('PRExtendedCost');
            $model = TbPr2::findOne($request->post('PRID'));
            $model->PRStatusID = 11;
            $model->PRApprovatime = date('H:i:s');
            $model->PRApprovaDate = date('Y-m-d');
            $model->PRTotal = number_format($PRExtendedCost, 2);
            $model->PRApproveBy = \Yii::$app->user->getId();
            $model->save();
            $sql = "
                 UPDATE tb_pritemdetail2
                    SET 
                     PRPackQtyApprove = PRPackQtyVerify,
                     ItemPackCostApprove = ItemPackCostVerify,
                     PRApprovedUnitCost = PRVerifyUnitCost,
                     PRApprovedOrderQty = PRVerifyQty,
                     ItemPackIDApprove = ItemPackIDVerify
                    WHERE
                            PRID = $model->PRID;
                 ";
            Yii::$app->db->createCommand($sql)->execute();
            Yii::$app->session->setFlash('success', 'Approve ' . $model['PRNum'] . ' Success!');
            return $this->redirect('/km4/pr/default/list-approve');
        } else {
            return false;
        }
    }

    public function actionItemDetails() {
        if (isset($_POST['expandRowKey'])) {
            $query = Tbpritemdetail2temp::findOne($_POST['expandRowKey']);
            $dataProvider1 = new SqlDataProvider([
                'sql' => 'SELECT
                        (SELECT SUM(tb_pcplantpudetail.TPUOrderQty) FROM tb_pcplantpudetail WHERE tb_pcplantpudetail.TMTID_TPU = :TMTID_TPU) AS plan_qty,
                        (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_TPU = :TMTID_TPU AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                        (ifnull((SELECT SUM(tb_pcplantpudetail.TPUOrderQty)
                                                FROM tb_pcplantpudetail
                                                WHERE tb_pcplantpudetail.TMTID_TPU = :TMTID_TPU),0) 
                        - ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty)
                                                FROM tb_pritemdetail2
                                                WHERE tb_pritemdetail2.TMTID_TPU = :TMTID_TPU
                                                AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                        0 AS pr_wip,
                        0 AS po_wip,
                        (SELECT tb_gpuconsume_rate.consume_rate FROM tb_gpuconsume_rate WHERE tb_gpuconsume_rate.TMTID_GPU = :TMTID_GPU) AS consume_rate
                FROM
                        tb_pritemdetail2
                INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID,
                 tb_gpuconsume_rate
                WHERE
                        tb_pr2.PRStatusID = 11
                GROUP BY
                        plan_qty',
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':TMTID_TPU' => $query['TMTID_TPU'], ':PRID' => $query['PRID']],
            ]);
            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsTPU(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_tpu(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item_details', [
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'dataProvider3' => $dataProvider3,
                        'dataProvider4' => $dataProvider4,
                        'QueryGPU' => $QueryGPU,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionItemDetailsVerify() {
        if (isset($_POST['expandRowKey'])) {
            $query = Tbpritemdetail2::findOne($_POST['expandRowKey']);
            $dataProvider1 = new SqlDataProvider([
                'sql' => 'SELECT
                        (SELECT SUM(tb_pcplantpudetail.TPUOrderQty) FROM tb_pcplantpudetail WHERE tb_pcplantpudetail.TMTID_TPU = :TMTID_TPU) AS plan_qty,
                        (SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty) FROM tb_pritemdetail2 WHERE tb_pritemdetail2.TMTID_TPU = :TMTID_TPU AND tb_pritemdetail2.PRID < :PRID) AS pr_qty_cum,
                        (ifnull((SELECT SUM(tb_pcplantpudetail.TPUOrderQty)
                                                FROM tb_pcplantpudetail
                                                WHERE tb_pcplantpudetail.TMTID_TPU = :TMTID_TPU),0) 
                        - ifnull((SELECT SUM(tb_pritemdetail2.PRApprovedOrderQty)
                                                FROM tb_pritemdetail2
                                                WHERE tb_pritemdetail2.TMTID_TPU = :TMTID_TPU
                                                AND tb_pritemdetail2.PRID < :PRID),0)) AS pr_qty_avalible,
                        0 AS pr_wip,
                        0 AS po_wip,
                        (SELECT tb_gpuconsume_rate.consume_rate FROM tb_gpuconsume_rate WHERE tb_gpuconsume_rate.TMTID_GPU = :TMTID_GPU) AS consume_rate
                FROM
                        tb_pritemdetail2
                INNER JOIN tb_pr2 ON tb_pritemdetail2.PRID = tb_pr2.PRID,
                 tb_gpuconsume_rate
                WHERE
                        tb_pr2.PRStatusID = 11
                GROUP BY
                        plan_qty',
                'params' => [':TMTID_GPU' => $query['TMTID_GPU'], ':TMTID_TPU' => $query['TMTID_TPU'], ':PRID' => $query['PRID']],
            ]);
            $searchModel2 = new VwStkStatusSearch();
            $dataProvider2 = $searchModel2->searchDetailsTPU(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel3 = new VwQuPricelistSearch();
            $dataProvider3 = $searchModel3->search_tpu(Yii::$app->request->queryParams, $query['TMTID_TPU']);

            $searchModel4 = new VwPurchasingHistorySearch();
            $dataProvider4 = $searchModel4->search(Yii::$app->request->queryParams, $query['TMTID_GPU']);

            $QueryGPU = VwGpustdCost::findOne($query['TMTID_GPU']);

            return $this->renderAjax('_item_details', [
                        'dataProvider1' => $dataProvider1,
                        'dataProvider2' => $dataProvider2,
                        'dataProvider3' => $dataProvider3,
                        'dataProvider4' => $dataProvider4,
                        'QueryGPU' => $QueryGPU,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionViewDetails($data, $PRNum) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $dataProvider = new ActiveDataProvider([
                    'query' => TbPritemdetail2::find()
                            ->select(['TMTID_TPU', 'PRExtendedCost', 'PRItemOnPCPlan', 'ids', 'ItemID', 'ItemName', 'PROrderQty', 'PRUnitCost', 'PRVerifyQty', 'PRVerifyUnitCost', 'ItemPackID', 'ItemPackIDVerify'])
                            ->where(['PRID' => $data]),
                    'pagination' => [
                        'pageSize' => false,
                    ],
                ]);
                return [
                    'title' => '<strong>ใบขอซื้อเลขที่ ' . $PRNum . '</strong>',
                    'content' => $this->renderAjax('view_details', [
                        'dataProvider' => $dataProvider,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    
    public function actionSaveHeader() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $model = TbPr2Temp::findOne($post['TbPr2Temp']['PRID']);
            $model->PRNum = empty($post['TbPr2Temp']['PRNum']) ? 'Draft' : $post['TbPr2Temp']['PRNum'];
            $model->PRDate = empty($post['TbPr2Temp']['PRDate']) ? null : Yii::$app->dateconvert->convertThaiToMysqlDate2($post['TbPr2Temp']['PRDate']);
            $model->DepartmentID = empty($post['TbPr2Temp']['DepartmentID']) ? null : $post['TbPr2Temp']['DepartmentID'];
            $model->SectionID = empty($post['TbPr2Temp']['SectionID']) ? null : $post['TbPr2Temp']['SectionID'];
            $model->PRExpectDate = empty($post['TbPr2Temp']['PRExpectDate']) ? null : $post['TbPr2Temp']['PRExpectDate'];
            $model->PRReasonNote = empty($post['TbPr2Temp']['PRReasonNote']) ? null : $post['TbPr2Temp']['PRReasonNote'];
            $model->POTypeID = empty($post['TbPr2Temp']['POTypeID']) ? null : $post['TbPr2Temp']['POTypeID'];
            $model->PRbudgetID = empty($post['TbPr2Temp']['PRbudgetID']) ? null : $post['TbPr2Temp']['PRbudgetID'];
            $model->save();
            return $post['TbPr2Temp']['PRID'];
        } else {
            return false;
        }
    }

}
