<?php

namespace app\modules\pharmacy\controllers;

use Yii;
use app\modules\pharmacy\models\TbCpoe;
use app\modules\pharmacy\models\TbCpoeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
#models
use app\modules\pharmacy\models\VwPtServiceListOpSearch;
use app\modules\pharmacy\models\VwPtServiceListOp;
use app\modules\pharmacy\models\VwPtAr;
use app\modules\pharmacy\models\VwCpoeRxDetail2Search;
use app\modules\pharmacy\models\TbCpoeDetail;
use app\modules\pharmacy\models\VwCpoeDruglistOp;
use app\modules\pharmacy\models\TbIsedReason;
use app\modules\pharmacy\models\VwCpoeDrugadmitDefault;
use app\modules\pharmacy\models\VwCpoeDrugDefault;
use app\modules\pharmacy\models\VwSigCode;
use app\modules\pharmacy\models\VwCpoeRxHeader;
use app\modules\pharmacy\models\TbCpoeItemtype;
use app\modules\pharmacy\models\VwIvsolutionDetail;
use app\modules\pharmacy\models\TbDrugprandialadvice;
use app\modules\pharmacy\models\TbStdTrpChemoSearch;
use app\modules\pharmacy\models\TbStdTrpChemo;
use app\modules\pharmacy\models\VwStdDrugsetDetailSearch;
use app\modules\pharmacy\models\VwCpoeRxHeaderSearch;
use app\modules\pharmacy\models\VwProtocolForCr;
use app\modules\pharmacy\models\TbPtAr;
use app\modules\pharmacy\models\TbFiInvDetail;
use app\modules\pharmacy\models\TbPrintDruglabel;
use app\modules\pharmacy\models\VwCpoeRxDetail2;

class RxController extends Controller {

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

    public function actionCreateOrderChemo($data, $type) {
        $userid = Yii::$app->user->identity->id;
        $maxid = TbCpoe::find()->max('cpoe_id') + 1;
        if ($type == 'chemo') {
            $cpoetype = '1012';
        } elseif ($type == 'homemed') {
            $cpoetype = '1011';
        }
        Yii::$app->db->createCommand('CALL cmd_pt_rxorder_create(:pt_vn_number,:userid,:cpoe_id,:cpoe_type);')
                ->bindParam(':pt_vn_number', $data)
                ->bindParam(':userid', $userid)
                ->bindParam(':cpoe_id', $maxid)
                ->bindParam(':cpoe_type', $cpoetype)
                ->execute();
        return $this->redirect(['order-chemo', 'id' => $maxid, 'type' => $type]);
    }

    public function actionOrderChemo($id, $type) {
        $modelCpoe = $this->findModel($id);
        if (empty($type)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($type == 'chemo' || $type == 'homemed') {
            if (($header = VwPtServiceListOp::findOne($modelCpoe['pt_vn_number'])) !== null) {
                $ptar = VwPtAr::find()->where(['pt_visit_number' => $modelCpoe['pt_vn_number']])->one();
                $headermodal = $header->getHeadermodalOP($modelCpoe['pt_vn_number']);
                $creditgroups = $this->getCreditGroup($modelCpoe['pt_vn_number']);
                $command = (new \yii\db\Query())
                        ->select(['ItemID', 'credit_group_id', 'Itemdetail', 'ItemQtyAvalible', 'DispUnit', 'ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt', 'NED_required', 'Jor2_required', 'TMTID_GPU'])
                        ->from('vw_cpoe_druglist_op')
                        ->where(['IN', 'credit_group_id', $creditgroups])
                        ->all();
                $druglistop = $this->generateTableop($command);
                $searchModel = new VwCpoeRxDetail2Search();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
                return $this->render('order-chemo', [
                            'header' => $header,
                            'ptar' => $ptar,
                            'modelCpoe' => $modelCpoe,
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'headermodal' => $headermodal,
                            'type' => $type,
                            'druglistop' => $druglistop,
                ]);
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndex() {
        $searchModel = new VwPtServiceListOpSearch();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrderHistory($data) {
        if (($header = VwPtServiceListOp::findOne($data)) !== null) {
            $ptar = VwPtAr::find()->where(['pt_visit_number' => $data])->all();
            return $this->render('order-history', [
                        'header' => $header,
                        'ptar' => $ptar,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionArdetail($vn) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $ardetails = VwPtAr::find()->where(['pt_visit_number' => $request->get('vn')])->all();
                $headerdetail = VwPtServiceListOp::findOne(['pt_visit_number' => $vn]);
                $headermodal = $headerdetail->getHeadermodalOP($request->get('vn'));
                return [
                    'title' => 'สิทธิการรักษา ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_ardetails', [
                        'ardetails' => $ardetails,
                        'profile' => $headerdetail,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /*
      public function actionView($id) {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      }

      public function actionCreate() {
      $model = new TbCpoe();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->cpoe_id]);
      } else {
      return $this->render('create', [
      'model' => $model,
      ]);
      }
      }

      public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->cpoe_id]);
      } else {
      return $this->render('update', [
      'model' => $model,
      ]);
      }
      } */

    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();
        return true;
    }

    protected function findModel($id) {
        if (($model = TbCpoe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateByType($vn, $cpoeid, $type, $modalhd) {
        $request = Yii::$app->request;
        $cpoeModel = new TbCpoeDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $title = $this->getTitleModal($type);
                $headermodal = $modalhd/* $this->getHeadermodal($vn) */;
//                $creditgroups = $this->getCreditGroup($vn);
//                $command = (new \yii\db\Query())
//                        ->select(['ItemID', 'credit_group_id', 'Itemdetail', 'ItemQtyAvalible', 'DispUnit', 'ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt', 'NED_required', 'Jor2_required', 'TMTID_GPU'])
//                        ->from('vw_cpoe_druglist_op')
//                        ->where(['IN', 'credit_group_id', $creditgroups])
//                        ->all();
//                $druglistop = $this->generateTableop($command);
                //$druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $isedModel = TbIsedReason::find()->all();
                $cpoetype = ($type == 'homemed' ? TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all() : null);
                //$route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $cpoeModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoeModel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i>  ' . $title . ' ' . ' <span class="pull-right" style="color: black"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_create_bytype_modal', [
                        // 'druglistop' => $druglistop,
                        'cpoeModel' => $cpoeModel,
                        'isedModel' => $isedModel,
                        'cpoeid' => $cpoeid,
                        'route' => null,
                        'type' => $type,
                        'cpoetype' => $cpoetype,
                    ]),
                ];
            }
        }
    }

    public function actionEditByType($ids) {
        $request = Yii::$app->request;
        $cpoeModel = TbCpoeDetail::findOne($ids);
        if ($request->isAjax && $request->isGet) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $title = $this->getTitleModal($cpoeModel['cpoe_Itemtype']);
            $query_vn = VwCpoeRxHeader::findOne($cpoeModel['cpoe_id']);
            $headermodal = $this->getHeadermodal($query_vn['pt_vn_number']);
            //$creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
//            $command = (new \yii\db\Query())
//                    ->select(['ItemID', 'credit_group_id', 'Itemdetail', 'ItemQtyAvalible', 'DispUnit', 'ItemPrice', 'Item_Cr_Amt', 'Item_Pay_Amt', 'NED_required', 'Jor2_required', 'TMTID_GPU'])
//                    ->from('vw_cpoe_druglist_op')
//                    ->where(['IN', 'credit_group_id', $creditgroups])
//                    ->all();
//            $druglistop = $this->generateTableop($command);
            // $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
            $isedModel = TbIsedReason::find()->all();
            $cpoetype = ($cpoeModel['cpoe_Itemtype'] == '10' || $cpoeModel['cpoe_Itemtype'] == '20' ? TbCpoeItemtype::find()->where(['cpoe_itemtype_id' => [10, 20]])->all() : null);
            $route = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $cpoeModel['cpoe_route_id'], 'DrugPrandialAdviceID' => $cpoeModel['cpoe_drugprandialadviceid']]);
            $type = $cpoeModel['cpoe_Itemtype'] == '10' || $cpoeModel['cpoe_Itemtype'] == '20' ? 'homemed' : $cpoeModel['cpoe_Itemtype'];
            return [
                'title' => '<i class="glyphicon glyphicon-list"></i>  ' . $title . ' ' . ' <span class="pull-right" style="color: black"> ' . $headermodal . ' </span> ',
                'content' => $this->renderAjax('_create_bytype_modal', [
                    //'druglistop' => $druglistop,
                    'cpoeid' => $cpoeModel['cpoe_id'],
                    'cpoeModel' => $cpoeModel,
                    'isedModel' => $isedModel,
                    'route' => $route,
                    'type' => $type,
                    'cpoetype' => $cpoetype,
                ]),
            ];
        }
    }

    private function getHeadermodal($vn) {
        $modelheader = VwPtServiceListOp::findOne($vn);
        $headermodal = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="" style="color: black">อายุ</span> ' .
                $modelheader->pt_age_registry_date . ' <span class="">ปี</span>' . ' | ' .
                ' <span class="" style="color: black">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                ' <span class="" style="color: black">VN</span> ' . $modelheader->pt_visit_number . '&nbsp;';
        //' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
        return $headermodal;
    }

    private function getCreditGroup($vn) {
        if (!empty($vn)) {
            $querygroupid = TbPtAr::find()->where(['pt_visit_number' => $vn])->all();
            foreach ($querygroupid as $data) {
                $groupid[] = $data['credit_group_id'];
            }
            return $groupid;
        } else {
            return NULL;
        }
    }

    private function getTitleModal($type) {
        if ($type == 21) {
            return 'Keep Vein Open';
        } elseif ($type == 22) {
            return 'Premedication';
        } elseif ($type == 53) {
            return 'Chemo Injection';
        } elseif ($type == 'homemed' || $type == 10 || $type == 20) {
            return 'กำหนดรายการ';
        } elseif ($type == 54) {
            return 'Chemo P.O.';
        }
    }

    public function actionSelectitem() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query_drugdefault = VwCpoeDrugDefault::findOne($request->get('id'));
            $arr = array(
                'itemdetail' => $query_drugdefault->ItemDetail,
                'comment1' => $query_drugdefault->DrugAdminstration,
                'comment2' => $query_drugdefault->DrugPrecaution_lable,
                'comment3' => $query_drugdefault->DrugIndication_lable,
                'cpoe_doseqty' => $query_drugdefault->cpoe_doseqty,
                'RouteID' => $query_drugdefault->DrugRouteID,
                'AdviceID' => $query_drugdefault->DrugPrandialAdviceID,
                'RouteName' => $query_drugdefault->DrugRouteName,
                'AdviceName' => $query_drugdefault->DrugPrandialAdviceDesc,
                'TMTID_GPU' => $query_drugdefault->TMTID_GPU,
            );
            return $arr;
        }
    }

    public function actionGetrouteSelect() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $data1 = VwCpoeDrugadmitDefault::find()->where(['TMTID_GPU' => $request->get('gpu')])->all();
            $result = '<select id="cat-id" class="form-control">';
            $result .= '<option value="">Select Options</option>';
            foreach ($data1 as $datas) {
                $result .= '<option value="' . $datas['DrugRouteID'] . '">' . $datas['DrugRouteName'] . '</option>';
            }
            $result .= '</select>';

            $data2 = VwCpoeDrugadmitDefault::find()->where(['TMTID_GPU' => $request->get('gpu'), 'DrugRouteID' => $request->get('routeid')])->all();
            $result1 = '<select id="subcat-id" class="form-control">';
            $result1 .= '<option value="">Select Options</option>';
            foreach ($data2 as $datas) {
                $result1 .= '<option value="' . $datas['DrugPrandialAdviceID'] . '">' . $datas['DrugPrandialAdviceDesc'] . '</option>';
            }
            $result1 .= '</select>';

            $arr = array(
                'result' => $result,
                'result1' => $result1,
            );
            return Json::encode($arr);
        } else {
            $arr = array(
                'result' => '',
                'result1' => '',
            );
            return Json::encode($arr);
        }
    }

    public function actionChangestateSigcode() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $model = VwSigCode::findOne($request->post('id'));
            $arr = array(
                'cpoe_stat' => $model->cpoe_stat,
                'period_value' => $model->cpoe_period_value,
                'period_unit' => $model->cpoe_period_unit,
                'cpoe_frequency' => $model->cpoe_frequency,
                'frequency_value' => $model->cpoe_frequency_value,
                'frequency_unit' => $model->cpoe_frequency_unit,
            );
            return json_encode($arr);
        } else {
            return json_encode('');
        }
    }

    public function actionCalculateQty() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $post = $request->post();
            $pt_visit_number = $post['pt_visit_number'];
            $ItemID = !empty($post['TbCpoeDetail']['ItemID']) ? $post['TbCpoeDetail']['ItemID'] : '';
            $cpoe_once = !empty($post['TbCpoeDetail']['cpoe_once']) ? $post['TbCpoeDetail']['cpoe_once'] : '';
            $cpoe_repeat = !empty($post['TbCpoeDetail']['cpoe_repeat']) ? $post['TbCpoeDetail']['cpoe_repeat'] : '';
            $cpoe_doseqty = !empty($post['TbCpoeDetail']['cpoe_doseqty']) ? $post['TbCpoeDetail']['cpoe_doseqty'] : '';
            $cpoe_sig_code = !empty($post['TbCpoeDetail']['cpoe_sig_code']) ? $post['TbCpoeDetail']['cpoe_sig_code'] : '';
            $cpoe_period_value = !empty($post['TbCpoeDetail']['cpoe_period_value']) ? $post['TbCpoeDetail']['cpoe_period_value'] : '';
            $cpoe_period_unit = !empty($post['TbCpoeDetail']['cpoe_period_unit']) ? $post['TbCpoeDetail']['cpoe_period_unit'] : '';
            $cpoe_frequency = !empty($post['TbCpoeDetail']['cpoe_frequency']) ? $post['TbCpoeDetail']['cpoe_frequency'] : '';
            $cpoe_frequency_value = !empty($post['TbCpoeDetail']['cpoe_frequency_value']) ? $post['TbCpoeDetail']['cpoe_frequency_value'] : '';
            $cpoe_frequency_unit = !empty($post['TbCpoeDetail']['cpoe_frequency_unit']) ? $post['TbCpoeDetail']['cpoe_frequency_unit'] : '';
            $cpoe_dayrepeat = !empty($post['TbCpoeDetail']['cpoe_dayrepeat']) ? $post['TbCpoeDetail']['cpoe_dayrepeat'] : '';
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
            $command = Yii::$app->db->createCommand('select func_cal_drugdispenqty('
                            . ':cpoe_once,'
                            . ':cpoe_repeat,'
                            . ':cpoe_doseqty,'
                            . ':cpoe_sig_code,'
                            . ':cpoe_period_value,'
                            . ':cpoe_period_unit,'
                            . ':cpoe_frequency,'
                            . ':cpoe_frequency_value,'
                            . ':cpoe_frequency_unit,'
                            . ':cpoe_dayrepeat,'
                            . ':cpoe_dayrepeat_mon,'
                            . ':cpoe_dayrepeat_tue,'
                            . ':cpoe_dayrepeat_wed,'
                            . ':cpoe_dayrepeat_thu,'
                            . ':cpoe_dayrepeat_fri,'
                            . ':cpoe_dayrepeat_sat,'
                            . ':cpoe_dayrepeat_sun) as Qty;')
                    ->bindParam(":cpoe_once", $cpoe_once)
                    ->bindParam(":cpoe_repeat", $cpoe_repeat)
                    ->bindParam(":cpoe_doseqty", $cpoe_doseqty)
                    ->bindParam(":cpoe_sig_code", $cpoe_sig_code)
                    ->bindParam(":cpoe_period_value", $cpoe_period_value)
                    ->bindParam(":cpoe_period_unit", $cpoe_period_unit)
                    ->bindParam(":cpoe_frequency", $cpoe_frequency)
                    ->bindParam(":cpoe_frequency_value", $cpoe_frequency_value)
                    ->bindParam(":cpoe_frequency_unit", $cpoe_frequency_unit)
                    ->bindParam(":cpoe_dayrepeat", $cpoe_dayrepeat)
                    ->bindParam(":cpoe_dayrepeat_mon", $cpoe_dayrepeat_mon)
                    ->bindParam(":cpoe_dayrepeat_tue", $cpoe_dayrepeat_tue)
                    ->bindParam(":cpoe_dayrepeat_wed", $cpoe_dayrepeat_wed)
                    ->bindParam(":cpoe_dayrepeat_thu", $cpoe_dayrepeat_thu)
                    ->bindParam(":cpoe_dayrepeat_fri", $cpoe_dayrepeat_fri)
                    ->bindParam(":cpoe_dayrepeat_sat", $cpoe_dayrepeat_sat)
                    ->bindParam(":cpoe_dayrepeat_sun", $cpoe_dayrepeat_sun);
            $qty = $command->queryOne();


            $query = Yii::$app->db->createCommand('CALL cmd_cal_itemdrugprice_op2 (:ItemID, :ItemQty, :pt_visit_number,@Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt);'
                            . 'select  @Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt;')
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemQty', $qty['Qty'])
                    ->bindParam(':pt_visit_number', $pt_visit_number)
                    ->execute();
            $Item_Total_Amt = Yii::$app->db->createCommand("select @Item_Total_Amt;")->queryScalar();
            $Item_Cr_Amt = Yii::$app->db->createCommand("select @Item_Cr_Amt;")->queryScalar();
            $Item_Pay_Amt = Yii::$app->db->createCommand("select @Item_Pay_Amt;")->queryScalar();
            $result = array(
                'Item_Total_Amt' => number_format($Item_Total_Amt, 2),
                'Item_Cr_Amt' => number_format($Item_Cr_Amt, 2),
                'Item_Pay_Amt' => number_format($Item_Pay_Amt, 2),
                'Qty' => number_format($qty['Qty'], 2),
            );
            return json_encode($result);
        } else {
            return Json::encode('');
        }
    }

    public function actionCalculateDrugprice() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $ItemID = $request->post('ItemID');
            $ItemQty = $request->post('ItemQty');
            $pt_visit_number = $request->post('pt_visit_number');

            $query = Yii::$app->db->createCommand('CALL cmd_cal_itemdrugprice_op2 (:ItemID, :ItemQty, :pt_visit_number,@Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt);'
                            . 'select  @Item_Total_Amt, @Item_Cr_Amt, @Item_Pay_Amt;')
                    ->bindParam(':ItemID', $ItemID)
                    ->bindParam(':ItemQty', $ItemQty)
                    ->bindParam(':pt_visit_number', $pt_visit_number)
                    ->execute();
            $Item_Total_Amt = Yii::$app->db->createCommand("select @Item_Total_Amt;")->queryScalar();
            $Item_Cr_Amt = Yii::$app->db->createCommand("select @Item_Cr_Amt;")->queryScalar();
            $Item_Pay_Amt = Yii::$app->db->createCommand("select @Item_Pay_Amt;")->queryScalar();
            $result = array(
                'Item_Total_Amt' => number_format($Item_Total_Amt, 2),
                'Item_Cr_Amt' => number_format($Item_Cr_Amt, 2),
                'Item_Pay_Amt' => number_format($Item_Pay_Amt, 2),
            );
            return json_encode($result);
        } else {
            return json_encode('');
        }
    }

    public function actionSaveCpoedetail() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_ids = !empty($post['TbCpoeDetail']['cpoe_ids']) ? $post['TbCpoeDetail']['cpoe_ids'] : TbCpoeDetail::find()->max('cpoe_ids') + 1;
            $cpoe_detail_date = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
            $cpoe_detail_time = date('H:i:s', time());
            $cpoe_id = !empty($post['TbCpoeDetail']['cpoe_id']) ? $post['TbCpoeDetail']['cpoe_id'] : null;
            $cpoe_Itemtype = !empty($post['TbCpoeDetail']['cpoe_Itemtype']) ? $post['TbCpoeDetail']['cpoe_Itemtype'] : null;
            $cpoe_rxordertype = !empty($post['TbCpoeDetail']['cpoe_rxordertype']) ? $post['TbCpoeDetail']['cpoe_rxordertype'] : null;
            $ItemID = empty($post['TbCpoeDetail']['ItemID']) ? null : $post['TbCpoeDetail']['ItemID'];
            $ItemQty = !empty($post['TbCpoeDetail']['ItemQty']) ? str_replace(',', '', $post['TbCpoeDetail']['ItemQty']) : null;
            $ItemPrice = !empty($post['TbCpoeDetail']['ItemPrice']) ? str_replace(',', '', $post['TbCpoeDetail']['ItemPrice']) : null;
            $Item_Amt = $ItemQty * $ItemPrice;
            $ised = !empty($post['TbCpoeDetail']['ised_reason']) ? '1' : null;
            $ised_reason = !empty($post['TbCpoeDetail']['ised_reason']) ? $post['TbCpoeDetail']['ised_reason'] : null;
            $cpoe_narcotics_confirmed = !empty($post['TbCpoeDetail']['cpoe_narcotics_confirmed']) ? $post['TbCpoeDetail']['cpoe_narcotics_confirmed'] : null;
            $cpoe_ocpa = NULL;
            $cpoe_cpr = NULL;
            $Item_comment1 = !empty($post['TbCpoeDetail']['Item_comment1']) ? $post['TbCpoeDetail']['Item_comment1'] : null;
            $Item_comment2 = !empty($post['TbCpoeDetail']['Item_comment2']) ? $post['TbCpoeDetail']['Item_comment2'] : null;
            $Item_comment3 = !empty($post['TbCpoeDetail']['Item_comment3']) ? $post['TbCpoeDetail']['Item_comment3'] : null;
            $Item_comment4 = !empty($post['TbCpoeDetail']['Item_comment4']) ? $post['TbCpoeDetail']['Item_comment4'] : null;
            $cpoe_route_id = !empty($post['TbCpoeDetail']['cpoe_route_id']) ? $post['TbCpoeDetail']['cpoe_route_id'] : null;
            $cpoe_sig_code = !empty($post['TbCpoeDetail']['cpoe_sig_code']) ? $post['TbCpoeDetail']['cpoe_sig_code'] : null;
            $cpoe_iv_driprate = !empty($post['TbCpoeDetail']['cpoe_iv_driprate']) ? $post['TbCpoeDetail']['cpoe_iv_driprate'] : null;
            $cpoe_doseqty = !empty($post['TbCpoeDetail']['cpoe_doseqty']) ? $post['TbCpoeDetail']['cpoe_doseqty'] : null;
            $cpoe_prn_with_stat = null;
            $cpoe_prn_reason = !empty($post['TbCpoeDetail']['cpoe_prn_reason']) ? $post['TbCpoeDetail']['cpoe_prn_reason'] : null;
            $cpoe_stat = !empty($post['TbCpoeDetail']['cpoe_stat']) ? $post['TbCpoeDetail']['cpoe_stat'] : null;
            $cpoe_period = null;
            $cpoe_period_value = !empty($post['TbCpoeDetail']['cpoe_period_value']) ? $post['TbCpoeDetail']['cpoe_period_value'] : null;
            $cpoe_period_unit = !empty($post['TbCpoeDetail']['cpoe_period_unit']) ? $post['TbCpoeDetail']['cpoe_period_unit'] : null;
            $cpoe_frequency = !empty($post['TbCpoeDetail']['cpoe_frequency']) ? $post['TbCpoeDetail']['cpoe_frequency'] : null;
            $cpoe_frequency_value = !empty($post['TbCpoeDetail']['cpoe_frequency_value']) ? $post['TbCpoeDetail']['cpoe_frequency_value'] : null;
            $cpoe_frequency_unit = !empty($post['TbCpoeDetail']['cpoe_frequency_unit']) ? $post['TbCpoeDetail']['cpoe_frequency_unit'] : null;
            $cpoe_dayrepeat = !empty($post['TbCpoeDetail']['cpoe_dayrepeat']) ? $post['TbCpoeDetail']['cpoe_dayrepeat'] : null;
            $cpoe_dayrepeat_mon = !empty($post['cpoe_dayrepeat_mon']) ? '1' : '0';
            $cpoe_dayrepeat_tue = !empty($post['cpoe_dayrepeat_tue']) ? '1' : '0';
            $cpoe_dayrepeat_wed = !empty($post['cpoe_dayrepeat_wed']) ? '1' : '0';
            $cpoe_dayrepeat_thu = !empty($post['cpoe_dayrepeat_thu']) ? '1' : '0';
            $cpoe_dayrepeat_fri = !empty($post['cpoe_dayrepeat_fri']) ? '1' : '0';
            $cpoe_dayrepeat_sat = !empty($post['cpoe_dayrepeat_sat']) ? '1' : '0';
            $cpoe_dayrepeat_sun = !empty($post['cpoe_dayrepeat_sun']) ? '1' : '0';
            $cpoe_begindate = !empty($post['TbCpoeDetail']['cpoe_begindate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbCpoeDetail']['cpoe_begindate']) : null;
            $cpeo_begintime = !empty($post['TbCpoeDetail']['cpeo_begintime']) ? $post['TbCpoeDetail']['cpeo_begintime'] : null;
            $cpoe_enddate = !empty($post['TbCpoeDetail']['cpoe_enddate']) ? Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbCpoeDetail']['cpoe_enddate']) : null;
            $cpoe_endtime = !empty($post['TbCpoeDetail']['cpoe_endtime']) ? $post['TbCpoeDetail']['cpoe_endtime'] : null;
            $cpoe_repeat = !empty($post['TbCpoeDetail']['cpoe_repeat']) ? $post['TbCpoeDetail']['cpoe_repeat'] : null;
            $cpoe_once = !empty($post['TbCpoeDetail']['cpoe_once']) ? $post['TbCpoeDetail']['cpoe_once'] : null;
            $cpoe_drugprandialadviceid = !empty($post['TbCpoeDetail']['cpoe_drugprandialadviceid']) ? $post['TbCpoeDetail']['cpoe_drugprandialadviceid'] : null;
            $cpoe_seq_mindelay = !empty($post['TbCpoeDetail']['cpoe_seq_mindelay']) ? $post['TbCpoeDetail']['cpoe_seq_mindelay'] : null;
            $chemo_regimen_ids = !empty($post['TbCpoeDetail']['chemo_regimen_ids']) ? $post['TbCpoeDetail']['chemo_regimen_ids'] : null;
            $Acpoe_ids = !empty($post['TbCpoeDetail']['cpoe_parentid']) ? $post['TbCpoeDetail']['cpoe_parentid'] : null;
            $Acpoe_seq = !empty($post['TbCpoeDetail']['cpoe_seq']) ? $post['TbCpoeDetail']['cpoe_seq'] : null;
            $cpoe_level = !empty($post['TbCpoeDetail']['cpoe_level']) ? $post['TbCpoeDetail']['cpoe_level'] : null;
            $cpoe_drugset_id = null;
            if ($cpoe_Itemtype == 21) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_kvosolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 22) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_premed('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 51) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_basesolution('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $Acpoe_seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->execute();
                $model = TbCpoeDetail::findOne($cpoe_ids);
                $model->chemo_regimen_ids = $chemo_regimen_ids;
                $model->save();
                return true;
            } elseif ($cpoe_Itemtype == 52) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_additive('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':Acpoe_ids,'
                                . ':Acpoe_seq,'
                                . ':cpoe_level,'
                                . ':cpoe_drugset_id,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':Acpoe_ids', $Acpoe_ids)
                        ->bindParam(':Acpoe_seq', $Acpoe_seq)
                        ->bindParam(':cpoe_level', $cpoe_level)
                        ->bindParam(':cpoe_drugset_id', $cpoe_drugset_id)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->execute();
                $model = TbCpoeDetail::findOne($cpoe_ids);
                $model->chemo_regimen_ids = $chemo_regimen_ids;
                $model->save();
                return true;
            } elseif ($cpoe_Itemtype == 50 || $cpoe_Itemtype == 40) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_itemsave('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 53) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_chemoinj('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay,'
                                . ':chemo_regimen_ids);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 10 || $cpoe_Itemtype == 20) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave2('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->execute();
                return true;
            } elseif ($cpoe_Itemtype == 54) {
                Yii::$app->db->createCommand('CALL cmd_cpoe_rxitemsave_chemopo('
                                . ':cpoe_ids,'
                                . ':cpoe_detail_date,'
                                . ':cpoe_detail_time,'
                                . ':cpoe_id,'
                                . ':cpoe_Itemtype,'
                                . ':cpoe_rxordertype,'
                                . ':ItemID,'
                                . ':ItemQty,'
                                . ':ItemPrice,'
                                . ':Item_Amt,'
                                . ':ised,'
                                . ':ised_reason,'
                                . ':cpoe_narcotics_confirmed,'
                                . ':cpoe_ocpa,'
                                . ':cpoe_cpr,'
                                . ':Item_comment1,'
                                . ':Item_comment2,'
                                . ':Item_comment3,'
                                . ':Item_comment4,'
                                . ':cpoe_route_id,'
                                . ':cpoe_sig_code,'
                                . ':cpoe_iv_driprate,'
                                . ':cpoe_doseqty,'
                                . ':cpoe_prn_with_stat,'
                                . ':cpoe_prn_reason,'
                                . ':cpoe_stat,'
                                . ':cpoe_period,'
                                . ':cpoe_period_value,'
                                . ':cpoe_period_unit,'
                                . ':cpoe_frequency,'
                                . ':cpoe_frequency_value,'
                                . ':cpoe_frequency_unit,'
                                . ':cpoe_dayrepeat,'
                                . ':cpoe_dayrepeat_mon,'
                                . ':cpoe_dayrepeat_tue,'
                                . ':cpoe_dayrepeat_wed,'
                                . ':cpoe_dayrepeat_thu,'
                                . ':cpoe_dayrepeat_fri,'
                                . ':cpoe_dayrepeat_sat,'
                                . ':cpoe_dayrepeat_sun,'
                                . ':cpoe_begindate,'
                                . ':cpeo_begintime,'
                                . ':cpoe_enddate,'
                                . ':cpoe_endtime,'
                                . ':cpoe_repeat,'
                                . ':cpoe_once,'
                                . ':cpoe_drugprandialadviceid,'
                                . ':cpoe_seq_mindelay,'
                                . ':chemo_regimen_ids);')
                        ->bindParam(':cpoe_ids', $cpoe_ids)
                        ->bindParam(':cpoe_detail_date', $cpoe_detail_date)
                        ->bindParam(':cpoe_detail_time', $cpoe_detail_time)
                        ->bindParam(':cpoe_id', $cpoe_id)
                        ->bindParam(':cpoe_Itemtype', $cpoe_Itemtype)
                        ->bindParam(':cpoe_rxordertype', $cpoe_rxordertype)
                        ->bindParam(':ItemID', $ItemID)
                        ->bindParam(':ItemQty', $ItemQty)
                        ->bindParam(':ItemPrice', $ItemPrice)
                        ->bindParam(':Item_Amt', $Item_Amt)
                        ->bindParam(':ised', $ised)
                        ->bindParam(':ised_reason', $ised_reason)
                        ->bindParam(':cpoe_narcotics_confirmed', $cpoe_narcotics_confirmed)
                        ->bindParam(':cpoe_ocpa', $cpoe_ocpa)
                        ->bindParam(':cpoe_cpr', $cpoe_cpr)
                        ->bindParam(':Item_comment1', $Item_comment1)
                        ->bindParam(':Item_comment2', $Item_comment2)
                        ->bindParam(':Item_comment3', $Item_comment3)
                        ->bindParam(':Item_comment4', $Item_comment4)
                        ->bindParam(':cpoe_route_id', $cpoe_route_id)
                        ->bindParam(':cpoe_sig_code', $cpoe_sig_code)
                        ->bindParam(':cpoe_iv_driprate', $cpoe_iv_driprate)
                        ->bindParam(':cpoe_doseqty', $cpoe_doseqty)
                        ->bindParam(':cpoe_prn_with_stat', $cpoe_prn_with_stat)
                        ->bindParam(':cpoe_prn_reason', $cpoe_prn_reason)
                        ->bindParam(':cpoe_stat', $cpoe_stat)
                        ->bindParam(':cpoe_period', $cpoe_period)
                        ->bindParam(':cpoe_period_value', $cpoe_period_value)
                        ->bindParam(':cpoe_period_unit', $cpoe_period_unit)
                        ->bindParam(':cpoe_frequency', $cpoe_frequency)
                        ->bindParam(':cpoe_frequency_value', $cpoe_frequency_value)
                        ->bindParam(':cpoe_frequency_unit', $cpoe_frequency_unit)
                        ->bindParam(':cpoe_dayrepeat', $cpoe_dayrepeat)
                        ->bindParam(':cpoe_dayrepeat_mon', $cpoe_dayrepeat_mon)
                        ->bindParam(':cpoe_dayrepeat_tue', $cpoe_dayrepeat_tue)
                        ->bindParam(':cpoe_dayrepeat_wed', $cpoe_dayrepeat_wed)
                        ->bindParam(':cpoe_dayrepeat_thu', $cpoe_dayrepeat_thu)
                        ->bindParam(':cpoe_dayrepeat_fri', $cpoe_dayrepeat_fri)
                        ->bindParam(':cpoe_dayrepeat_sat', $cpoe_dayrepeat_sat)
                        ->bindParam(':cpoe_dayrepeat_sun', $cpoe_dayrepeat_sun)
                        ->bindParam(':cpoe_begindate', $cpoe_begindate)
                        ->bindParam(':cpeo_begintime', $cpeo_begintime)
                        ->bindParam(':cpoe_enddate', $cpoe_enddate)
                        ->bindParam(':cpoe_endtime', $cpoe_endtime)
                        ->bindParam(':cpoe_repeat', $cpoe_repeat)
                        ->bindParam(':cpoe_once', $cpoe_once)
                        ->bindParam(':cpoe_drugprandialadviceid', $cpoe_drugprandialadviceid)
                        ->bindParam(':cpoe_seq_mindelay', $cpoe_seq_mindelay)
                        ->bindParam(':chemo_regimen_ids', $chemo_regimen_ids)
                        ->execute();
                return true;
            }
        }
    }

    public function actionGetDisunit() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $disunit = VwCpoeDrugDefault::findOne($request->post('id'));
            return Json::encode($disunit->DispUnit);
        } else {
            return Json::encode('');
        }
    }

    public function actionDeleteDetails() {
        $id = Yii::$app->request->post('id');
        TbCpoeDetail::findOne($id)->delete();
        TbFiInvDetail::deleteAll('cpoe_ids = :cpoe_ids', [':cpoe_ids' => $id]);
        if (($model = TbCpoeDetail::find()->where(['cpoe_parentid' => $id])->all()) !== null) {
            TbCpoeDetail::deleteAll('cpoe_parentid = :cpoe_parentid', [':cpoe_parentid' => $id]);
        }
        return true;
    }

    public function actionIvsolutionPremed() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $cpoe_ids = TbCpoeDetail::find()->max('cpoe_ids') + 1;
                $cpoeid = $request->post('cpoeid');
                $headermodel = VwCpoeRxHeader::findOne($cpoeid);
                $this->CreateIvsolutionPremed($cpoeid, $cpoe_ids);
                $invmodel = VwIvsolutionDetail::find()->where(['cpoe_parentid' => $cpoe_ids])->all();
                $detailmodel = TbCpoeDetail::findOne($cpoe_ids);

                $query_vn = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $adviceid = ArrayHelper::map($this->getDrugadvice($detailmodel->cpoe_drugprandialadviceid), 'id', 'name');
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'parentid' => $cpoe_ids,
                            'headermodel' => $headermodel,
                            'detailmodel' => $detailmodel,
                            'cpoeid' => $cpoeid,
                            'druglistop' => $druglistop,
                            'route' => $queryroute,
                            'adviceid' => $adviceid,
                ]);
            }
        }
    }

    private function CreateIvsolutionPremed($cpoeid, $cpoe_ids) {
        Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_create_premed(:cpoe_id,:cpoe_ids);')
                ->bindParam(':cpoe_id', $cpoeid)
                ->bindParam(':cpoe_ids', $cpoe_ids)
                ->execute();
        return $cpoe_ids;
    }

    public function actionIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $cpoe_ids = TbCpoeDetail::find()->max('cpoe_ids') + 1;
                $cpoeid = $request->post('cpoeid');

                $headermodel = VwCpoeRxHeader::findOne($cpoeid);
                $this->CreateIvsolution($cpoeid, $cpoe_ids);
                $invmodel = VwIvsolutionDetail::find()->where(['cpoe_parentid' => $cpoe_ids])->all();
                $detailmodel = TbCpoeDetail::findOne($cpoe_ids);

                $query_vn = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
                $adviceid = ArrayHelper::map($this->getDrugadvice($detailmodel->cpoe_drugprandialadviceid), 'id', 'name');
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);

                return $this->renderAjax('_formiv', [
                            'invmodel' => $invmodel,
                            'parentid' => $cpoe_ids,
                            'headermodel' => $headermodel,
                            'detailmodel' => $detailmodel,
                            'cpoeid' => $cpoeid,
                            'druglistop' => $druglistop,
                            'route' => $queryroute,
                            'adviceid' => $adviceid,
                ]);
            }
        }
    }

    private function CreateIvsolution($cpoeid, $cpoe_ids) {
        Yii::$app->db->createCommand('CALL cmd_cpoe_ivsolution_create(:cpoe_id,:cpoe_ids);')
                ->bindParam(':cpoe_id', $cpoeid)
                ->bindParam(':cpoe_ids', $cpoe_ids)
                ->execute();
        return $cpoe_ids;
    }

    public function actionEditIvsolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = $request->post('id');
            $detailmodel = TbCpoeDetail::findOne($id);
            $headermodel = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
            $invmodel = VwIvsolutionDetail::find()->where(['cpoe_parentid' => $id])->all();

            $query_vn = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
            $creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
            $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups])->all();
            $adviceid = ArrayHelper::map($this->getDrugadvice($detailmodel->cpoe_drugprandialadviceid), 'id', 'name');
            $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
            return $this->renderAjax('_formiv', [
                        'invmodel' => $invmodel,
                        'parentid' => $id,
                        'headermodel' => $headermodel,
                        'cpoeid' => $detailmodel['cpoe_id'],
                        'druglistop' => $druglistop,
                        'detailmodel' => $detailmodel,
                        'route' => $queryroute,
                        'adviceid' => $adviceid,
            ]);
        }
    }

    public function actionCreateBase($cpoeid, $vn_number, $parentid) {
        $request = Yii::$app->request;
        $detailmodel = new TbCpoeDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn_number);
                $seq = TbCpoeDetail::findOne($parentid);
                $creditgroups = $this->getCreditGroup($vn_number);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups/* 'Class_GP' => '157' */])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'cpoeid' => $cpoeid,
                        'druglistop' => $druglistop,
                        'detailmodel' => $detailmodel,
                        'parentid' => $parentid,
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionEditBase($id) {
        $request = Yii::$app->request;
        $detailmodel = TbCpoeDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_vn_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups /* 'Class_GP' => '157' */])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Base Solution ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_base_modal', [
                        'cpoeid' => $detailmodel['cpoe_id'],
                        'druglistop' => $druglistop,
                        'detailmodel' => $detailmodel,
                        'parentid' => $detailmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $detailmodel['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionCreateAdditive($cpoeid, $vn_number, $parentid) {
        $request = Yii::$app->request;
        $detailmodel = new TbCpoeDetail();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $headermodal = $this->getHeadermodal($vn_number);
                $seq = TbCpoeDetail::findOne($parentid);
                $creditgroups = $this->getCreditGroup($vn_number);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups, /* 'Class_GP' => '101' */])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'cpoeid' => $cpoeid,
                        'druglistop' => $druglistop,
                        'detailmodel' => $detailmodel,
                        'parentid' => $parentid,
                        'route' => $queryroute,
                        'seq' => $seq['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionEditAdditive($id) {
        $request = Yii::$app->request;
        $detailmodel = TbCpoeDetail::findOne($id);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                $query_vn = VwCpoeRxHeader::findOne($detailmodel['cpoe_id']);
                $headermodal = $this->getHeadermodal($query_vn['pt_vn_number']);
                $creditgroups = $this->getCreditGroup($query_vn['pt_vn_number']);
                $druglistop = VwCpoeDruglistOp::find()->where(['credit_group_id' => $creditgroups, 'Class_GP' => '101'])->all();
                $queryroute = VwCpoeDrugadmitDefault::findOne(['DrugRouteID' => $detailmodel['cpoe_route_id'], 'DrugPrandialAdviceID' => $detailmodel['cpoe_drugprandialadviceid']]);
                return [
                    'title' => '<i class="glyphicon glyphicon-list"></i> Drug Additive ' . ' <span class="pull-right"> ' . $headermodal . ' </span> ',
                    'content' => $this->renderAjax('_additive_modal', [
                        'cpoeid' => $detailmodel['cpoe_id'],
                        'druglistop' => $druglistop,
                        'detailmodel' => $detailmodel,
                        'parentid' => $detailmodel['cpoe_parentid'],
                        'route' => $queryroute,
                        'seq' => $detailmodel['cpoe_seq'],
                    ]),
                ];
            }
        }
    }

    public function actionGetDrugadvice() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $DrugrouteID = $parents[0];
                $out = $this->getDrugadvice($DrugrouteID);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getDrugadvice($id) {
        $datas = TbDrugprandialadvice::find()->where(['DrugRouteID' => $id])->all();
        return $this->MapData($datas, 'DrugPrandialAdviceID', 'DrugPrandialAdviceDesc');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionGettbBasesolution() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => [51]])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbBasesolution">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    
                    <th class="text-center">รายการ</th>
                    <th class="text-center">ปริมาณ</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center">เบิกได้</th>
                    <th class="text-center">เบิกไม่ได้</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                //$table .= '<td class="text-center">' . $result->cpoe_itemtype_decs . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-base', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';

                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }

    public function actionGettbDrugadditive() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $query = VwIvsolutionDetail::find()
                    ->where(['cpoe_parentid' => $request->post('parent'), 'cpoe_Itemtype' => 52])
                    ->all();
            $table = '<table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbDrugAdditive">'
                    . '<thead>
                <tr>
                    <th class="text-center">รหัสสินค้า</th>
                    
                    <th class="text-center">รายการ</th>
                    <th class="text-center">ปริมาณ</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center">เบิกได้</th>
                    <th class="text-center">เบิกไม่ได้</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($query as $result) {
                $table .= '<tr>';
                $table .= '<td class="text-center">' . $result->ItemID . '</td>';
                //$table .= '<td class="text-center">' . $result->cpoe_itemtype_decs . '</td>';
                $table .= '<td class="text-left">' . $result->ItemDetail . '</td>';
                $table .= '<td class="text-center">' . $result->ItemQty1 . '</td>';
                $table .= '<td class="text-right">' . $result->ItemPrice . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Cr_Amt_Sum . '</td>';
                $table .= '<td class="text-right">' . $result->Item_Pay_Amt_Sum . '</td>';
                $table .= '<td class="text-center" width="10%">' . Html::a('Edit', ['edit-additive', 'id' => $result['cpoe_ids']], ['class' => 'btn btn-xs btn-success', 'role' => 'modal-remote',]) . ' ' . Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger', 'onclick' => 'DeleteSubparent(' . $result->cpoe_ids . ');']) . '</td>';
                $table .= '</tr>';
            }
            $table .= '</tbody>';
            $table .= '</table>';
            $arr = array(
                'table' => $table,
            );
            return json_encode($arr);
        }
    }

    public function actionSavedraftCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_id = $post['TbCpoe']['cpoe_id'];
            $cpoe_type = !empty($post['TbCpoe']['cpoe_type']) ? $post['TbCpoe']['cpoe_type'] : null;
            $cpoe_date = empty($post['TbCpoe']['cpoe_date']) ? null : Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbCpoe']['cpoe_date']);
            $cpoe_order_section = !empty($post['TbCpoe']['cpoe_order_section']) ? $post['TbCpoe']['cpoe_order_section'] : null;
            $cpoe_comment = !empty($post['TbCpoe']['cpoe_comment']) ? $post['TbCpoe']['cpoe_comment'] : null;
            $cpoe_order_by = !empty($post['TbCpoe']['cpoe_order_by']) ? $post['TbCpoe']['cpoe_order_by'] : null;
            $pt_trp_regimen_name = !empty($post['TbCpoe']['pt_trp_regimen_name']) ? $post['TbCpoe']['pt_trp_regimen_name'] : null;
            $chemo_cycle_seq = !empty($post['TbCpoe']['chemo_cycle_seq']) ? $post['TbCpoe']['chemo_cycle_seq'] : null;
            $chemo_cycle_day = !empty($post['TbCpoe']['chemo_cycle_day']) ? $post['TbCpoe']['chemo_cycle_day'] : null;
            $pt_trp_regimen_paycode = !empty($post['TbCpoe']['pt_trp_regimen_paycode']) ? $post['TbCpoe']['pt_trp_regimen_paycode'] : null;
            $pt_cpr_number = !empty($post['TbCpoe']['pt_cpr_number']) ? $post['TbCpoe']['pt_cpr_number'] : null;
            $pt_ocpa_number = !empty($post['TbCpoe']['pt_ocpa_number']) ? $post['TbCpoe']['pt_ocpa_number'] : null;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsavedrafe_pharma(:cpoe_id, :cpoe_type,:cpoe_date,:cpoe_order_section,:cpoe_comment,:cpoe_order_by,:pt_trp_regimen_name,:chemo_cycle_seq,:chemo_cycle_day,:pt_trp_regimen_paycode,:pt_cpr_number,:pt_ocpa_number);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':cpoe_type', $cpoe_type)
                    ->bindParam(':cpoe_date', $cpoe_date)
                    ->bindParam(':cpoe_order_section', $cpoe_order_section)
                    ->bindParam(':cpoe_comment', $cpoe_comment)
                    ->bindParam(':cpoe_order_by', $cpoe_order_by)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':pt_trp_regimen_paycode', $pt_trp_regimen_paycode)
                    ->bindParam(':pt_cpr_number', $pt_cpr_number)
                    ->bindParam(':pt_ocpa_number', $pt_ocpa_number)
                    ->execute();
            $model = $this->findModel($cpoe_id);
            return $model['cpoe_num'];
        }
    }

    public function actionSaveCpoe() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = $request->post();
            $cpoe_id = $post['TbCpoe']['cpoe_id'];
            $cpoe_type = !empty($post['TbCpoe']['cpoe_type']) ? $post['TbCpoe']['cpoe_type'] : null;
            $cpoe_date = empty($post['TbCpoe']['cpoe_date']) ? null : Yii::$app->componentdate->convertThaiToMysqlDate2($post['TbCpoe']['cpoe_date']);
            $cpoe_order_section = !empty($post['TbCpoe']['cpoe_order_section']) ? $post['TbCpoe']['cpoe_order_section'] : null;
            $cpoe_comment = !empty($post['TbCpoe']['cpoe_comment']) ? $post['TbCpoe']['cpoe_comment'] : null;
            $cpoe_order_by = !empty($post['TbCpoe']['cpoe_order_by']) ? $post['TbCpoe']['cpoe_order_by'] : null;
            $pt_trp_regimen_name = !empty($post['TbCpoe']['pt_trp_regimen_name']) ? $post['TbCpoe']['pt_trp_regimen_name'] : null;
            $chemo_cycle_seq = !empty($post['TbCpoe']['chemo_cycle_seq']) ? $post['TbCpoe']['chemo_cycle_seq'] : null;
            $chemo_cycle_day = !empty($post['TbCpoe']['chemo_cycle_day']) ? $post['TbCpoe']['chemo_cycle_day'] : null;
            $pt_trp_regimen_paycode = !empty($post['TbCpoe']['pt_trp_regimen_paycode']) ? $post['TbCpoe']['pt_trp_regimen_paycode'] : null;
            $pt_cpr_number = !empty($post['TbCpoe']['pt_cpr_number']) ? $post['TbCpoe']['pt_cpr_number'] : null;
            $pt_ocpa_number = !empty($post['TbCpoe']['pt_ocpa_number']) ? $post['TbCpoe']['pt_ocpa_number'] : null;
            Yii::$app->db->createCommand('CALL cmd_cpoe_rxsave_pharma(:cpoe_id, :cpoe_type,:cpoe_date,:cpoe_order_section,:cpoe_comment,:cpoe_order_by,:pt_trp_regimen_name,:chemo_cycle_seq,:chemo_cycle_day,:pt_trp_regimen_paycode,:pt_cpr_number,:pt_ocpa_number);')
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':cpoe_type', $cpoe_type)
                    ->bindParam(':cpoe_date', $cpoe_date)
                    ->bindParam(':cpoe_order_section', $cpoe_order_section)
                    ->bindParam(':cpoe_comment', $cpoe_comment)
                    ->bindParam(':cpoe_order_by', $cpoe_order_by)
                    ->bindParam(':pt_trp_regimen_name', $pt_trp_regimen_name)
                    ->bindParam(':chemo_cycle_seq', $chemo_cycle_seq)
                    ->bindParam(':chemo_cycle_day', $chemo_cycle_day)
                    ->bindParam(':pt_trp_regimen_paycode', $pt_trp_regimen_paycode)
                    ->bindParam(':pt_cpr_number', $pt_cpr_number)
                    ->bindParam(':pt_ocpa_number', $pt_ocpa_number)
                    ->execute();
            return 'success';
        }
    }

    public function actionSelectPackage($type, $data) {
        if (empty($type) || empty($data)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new TbStdTrpChemoSearch();
        if ($type == 'chemo') {
            $dataProvider = $searchModel->search_chemo(Yii::$app->request->queryParams);
        } elseif ($type == 'homemed') {
            $dataProvider = $searchModel->search_homemed(Yii::$app->request->queryParams);
        }
        return $this->render('select-package', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'data' => $data,
                    'type' => $type,
        ]);
    }

    public function actionStandardDetails() {
        if (isset($_POST['expandRowKey'])) {
            $modelChemo = TbStdTrpChemo::findOne($_POST['expandRowKey']);
            $searchModel = new VwStdDrugsetDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post(), $_POST['expandRowKey']);
            return $this->renderAjax('_standard-details', [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'modelChemo' => $modelChemo,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionSaveSelectPackage() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post = $request->post();
            $userid = Yii::$app->user->getId();
            $cpoe_id = $post['cpoeid'];
            $drugset_id = $post['drugset_id'];
            $type = $post['drugset_type'];
            Yii::$app->db->createCommand('CALL cmd_std_trp_select_to_rxorder(:userid, :cpoe_id,:drugset_id);')
                    ->bindParam(':userid', $userid)
                    ->bindParam(':cpoe_id', $cpoe_id)
                    ->bindParam(':drugset_id', $drugset_id)
                    ->execute();
            return $this->redirect(['order-chemo', 'id' => $cpoe_id, 'type' => $type]);
        }
    }

    public function actionOrderStatus() {
        $searchModel = new VwCpoeRxHeaderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order_status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelectProtocol() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $provider = new ActiveDataProvider([
                'query' => VwProtocolForCr::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
                    /*
                      'sort' => [
                      'defaultOrder' => [
                      'created_at' => SORT_DESC,
                      'title' => SORT_ASC,
                      ]
                      ], */
            ]);

            $Gridview = GridView::widget([
                        'dataProvider' => $provider,
                        'responsive' => false,
                        'hover' => true,
                        'layout' => '{items}',
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'tableOptions' => [
                            'class' => 'kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap',
                            'id' => 'table_protocol'
                        ],
                        'columns' => [
                                [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '',
                                'headerOptions' => ['class' => 'kartik-sheet-style']
                            ],
                                [
                                'header' => 'CA DX',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'Dx10CA',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['Dx10CA']) ? '-' : $model['Dx10CA'];
                                }
                            ],
                                [
                                'header' => 'CA State',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'chemo_state_desc',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['chemo_state_desc']) ? '-' : $model['chemo_state_desc'];
                                }
                            ],
                                [
                                'header' => 'Protocol',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'protocol_name',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['protocol_name']) ? '-' : $model['protocol_name'];
                                }
                            ],
                                [
                                'header' => 'รหัสเบิกจ่าย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'regimen_paycode',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['regimen_paycode']) ? '' : $model['regimen_paycode'];
                                }
                            ],
                                [
                                'class' => '\kartik\grid\ActionColumn',
                                'contentOptions' => ['class' => 'text-center',],
                                'template' => '{select}',
                                'noWrap' => true,
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'header' => 'Actions',
                                'buttons' => [
                                    'select' => function ($key, $model) {
                                        return Html::a('Select', 'javascript:void(0);', [
                                                    'title' => 'Select',
                                                    'class' => 'btn btn-success btn-xs',
                                                    'paycode' => empty($model['regimen_paycode']) ? '' : $model['regimen_paycode'],
                                                    'onclick' => 'SelctProtocol(this);'
                                        ]);
                                    },
                                ],
                            ],
                        ]
            ]);

            return [
                'title' => 'เลือกรหัสเบิกจ่าย',
                'content' => $this->renderAjax('_select_protocol', [
                    'Gridview' => $Gridview,
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
            ];
        }
    }

    public function actionExportDownload($id, $type) {
        $model = $this->findModel($id);
        $searchModel = new VwCpoeRxDetail2Search();
        $dataProvider = $searchModel->search_order(Yii::$app->request->queryParams, $id);
        $header = VwPtServiceListOp::findOne($model['pt_vn_number']);
        $ptar = VwPtAr::find()->where(['pt_visit_number' => $model['pt_vn_number']])->all();
        $query11 = VwCpoeRxDetail2::find()->where(['cpoe_id' => $id,'cpoe_Itemtype' => [10,20,21,22,40,50,53,54]])->asArray('cpoe_Itemtype')->groupBy('cpoe_Itemtype')->orderBy('cpoe_seq')->all();
        if ($type == 'A4') {
            $content = $this->renderPartial('_form_print', [
                'dataProvider' => $dataProvider,
                'type' => 'A4_content',
                'model' => $model,
                'header' => $header,
                'ptar' => $ptar,
                'query11' => $query11,
            ]);
            $marginTop = 70;
            $marginLeft = 10;
            $marginRight = 10;
            $marginBottom = false;
            $marginHeader = 5;
            $marginFooter = 5;
        } elseif ($type == 'Tabloid') {
            $content = $this->renderPartial('_form_print', [
                'dataProvider' => $dataProvider,
                'type' => 'slip_content',
                'model' => $model,
                'header' => $header,
                'ptar' => $ptar,
            ]);
            $marginTop = 55;
            $marginLeft = 3;
            $marginRight = 3;
            $marginBottom = 25;
            $marginHeader = 5;
            $marginFooter = 5;
        }
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => $type == 'Tabloid' ? [80, 150] : $type, //[60, 30], //กำหนดขนาด
            'marginTop' => $marginTop,
            'marginLeft' => $marginLeft,
            'marginRight' => $marginRight,
            'marginBottom' => $marginBottom,
            'marginHeader' => $marginHeader,
            'marginFooter' => $marginFooter,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'filename' => 'ใบสรุปรายการยา.pdf',
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            'options' => [
                'defaultheaderline' => 0,
                'defaultfooterline' => 0,
                'title' => 'ใบสรุปรายการยา',
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => $this->renderPartial('_form_print', [
                    'model' => $model,
                    'header' => $header,
                    'ptar' => $ptar,
                    'type' => $type,
                    'query11' => $query11,
                ]),
                'SetFooter' => $this->renderPartial('_form_print', [
                    'type' => 'footer',
                    'model' => $model,
                    'header' => $header,
                    'ptar' => $ptar,
                    'query11' => $query11,
                ]),
            ]
        ]);

        echo $pdf->render();
    }

    private function generateTableop($data) {
        $htl = '<table class="table table-bordered table-striped table-hover table-condensed" id="tbrxdetails" width="100%">
                            <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>' . Html::encode('รหัสสินค้า') . '</th>
                                        <th>' . Html::encode('รายการ') . '</th>
                                        <th>' . Html::encode('ยอดใช้ได้') . '</th>
                                        <th>' . Html::encode('หน่วย') . '</th>
                                        <th>' . Html::encode('ราคา/หน่วย') . '</th>
                                        <th>' . Html::encode('เบิกได้') . '</th>
                                        <th>' . Html::encode('เบิกไม่ได้') . '</th>
                                        <th>' . Html::encode('Actions') . '</th>
                                    </tr>
                                </thead>
                            <tbody>';
        foreach ($data as $result) {
            $htl .= '<tr id="' . $result['ItemID'] . '">';
            $htl .= '<td style="text-align: center;">' . '<div id="icon' . $result['ItemID'] . $result['credit_group_id'] . '" class="icon select"></div>' . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['Itemdetail'] . '</td>';
            $htl .= '<td style="text-align: center;">' . number_format($result['ItemQtyAvalible'], 2) . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['DispUnit'] . '</td>';
            $htl .= '<td style="text-align: center;">' . number_format($result['ItemPrice'], 2) . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Item_Cr_Amt'] . '</td>';
            $htl .= '<td style="text-align: center;">' . $result['Item_Pay_Amt'] . '</td>';
            $htl .= '<td style="text-align: center;">'
                    .
                    Html::a('Select', FALSE, [
                        'onclick' => 'SelectItemDrug' . '(this)',
                        'class' => 'btn btn-xs btn-success',
                        'data-toggle' => $result['credit_group_id'],
                        'ned' => $result['NED_required'],
                        'gp' => $result['Jor2_required'],
                        'data-id' => $result['TMTID_GPU'],
                        'id' => $result['ItemID'],
                        'detail' => $result['Itemdetail'],
                        'DispUnit' => $result['DispUnit'],
                        'ItemPrice' => $result['ItemPrice'],
                    ])
                    . '</td>';
            $htl .= '</tr>';
        }
        $htl .= '</tr></tbody>
                </table>
            ';
        return $htl;
    }

    public function actionCheckPrintLabel() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = TbPrintDruglabel::findAll(['orderid' => $request->post('ids'), 'orderstatus' => 1]);
            return $model != null ? 'duplicate' : 'print';
        } else {
            return false;
        }
    }

    public function actionPrintSingleLabel() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $cpoe_ids = $request->post('ids');
            Yii::$app->db->createCommand('CALL cmd_cpoe_rx_print(:cpoe_ids);')
                    ->bindParam(':cpoe_ids', $cpoe_ids)
                    ->execute();
            return 'Print Success!';
        } else {
            return false;
        }
    }

    public function actionSort($data) {
        $request = Yii::$app->request;
        $model = new TbCpoeDetail();
        if ($request->isAjax) {
            $items = [];
            $query = TbCpoeDetail::find()
                    ->where(['cpoe_id' => $data])
                    ->andWhere(['NOT IN', 'cpoe_Itemtype', [51, 52]])
                    ->orderBy('cpoe_seq')
                    ->all();
            foreach ($query as $v) {
                $items[$v->cpoe_ids] = [
                    'content' => empty($v->itemType->cpoe_itemtype_decs) ? '' : '<i class="glyphicon glyphicon-hand-up"></i> '.$v->itemType->cpoe_itemtype_decs . ' ' . $v->ItemID,
                        //'options' => ['data' => ['id' => $p->id]],
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => '<i class="glyphicon glyphicon-move"></i> Sort',
                    'content' => $this->renderAjax('_sort', [
                        'model' => $model,
                        'items' => $items,
                    ]),
                    //'footer' => Html::button('Close', ['class' => 'btn btn-default pull-right', 'data-dismiss' => "modal"]),
                ];
            }
        }
    }

    public function actionSaveSort() {
        $posted = Yii::$app->request->post();
        if ($posted) {
            $i = 1;
            $j = null;
            $ids = explode(',', $posted['TbCpoeDetail']['cpoe_seq']);
            foreach ($ids as $key) {
                $model = TbCpoeDetail::findOne($key);
                if ($model['cpoe_Itemtype'] == 40 || $model['cpoe_Itemtype'] == 50) {
                    $model->cpoe_seq = $i;
                    $model->save();
                    $j = $this->saveParentSort($key, ($i+1));
                    $i = $j++;
                } else {
                    $model->cpoe_seq = $i;
                    $model->save();
                    $i++;
                }
            }
            return json_encode($j);
        }
    }

    private function saveParentSort($key, $i) {
        $model = TbCpoeDetail::find()->where(['cpoe_parentid' => $key])->all();
        foreach ($model as $v) {
            $modalParent = TbCpoeDetail::findOne($v['cpoe_ids']);
            $modalParent->cpoe_seq = $i;
            $modalParent->save();
            $i++;
        }
        return $i;
    }

}
