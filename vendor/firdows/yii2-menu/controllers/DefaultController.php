<?php

namespace firdows\menu\controllers;

use Yii;
use firdows\menu\models\Menu;
use firdows\menu\models\MenuAuth;
use firdows\menu\models\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * DefaultController implements the CRUD actions for Menu model.
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionSorts() {
        $mainlist = $this->getMainmenu();
        return $this->render('sorts',['mainlist' => $mainlist]);
    }
    
    function actionSaveondrag() {
        $list = Yii::$app->getRequest()->post('list');
        $this->saveList($list);
    }

    private function Savelist($list, $parent_id = 0, $sort = 0) {
        $connection = \Yii::$app->db;
        foreach ($list as $item) {
            $sort++;
            $sql = "UPDATE menu SET parent_id = :parent_id,sort = :sort WHERE id = :id
        ";
            $user = $connection->createCommand($sql);
            $user->bindValue(":parent_id", $parent_id);
            $user->bindValue(":id", $item["id"]);
            $user->bindValue(":sort", $sort);
            $user->query();
            if (array_key_exists("children", $item)) {
                $this->Savelist($item["children"], $item["id"], $sort);
            }
        }
    }
    
    function getMainmenu($parent_id = 0) {
        $sql = "SELECT id, parent_id,title,icon,router,status FROM menu WHERE parent_id = " . $parent_id . " and menu_category_id = 1
        ORDER BY sort";
        $connection = \Yii::$app->db;
        $comman = $connection->createCommand($sql);
        $model = $comman->queryAll();
        foreach ($model as &$value) {
            $subresult = $this->getMainmenu($value["id"]);
            if (count($subresult) > 0) {
                $value['children'] = $subresult;
            }
        }
        unset($value);
        return $model;
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->renderAjax('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $model->icon = !empty($post['Menu']['icon']) ? 'menu-icon fa '.$post['Menu']['icon'] : null;
            $model->created_at = time();
            $model->parent_id = !empty($post['Menu']['parent_id']) ? $post['Menu']['parent_id'] : '0';
            $model->created_by = Yii::$app->user->id;


            $transaction = \Yii::$app->db->beginTransaction();
            try {

                if ($flag = $model->save(false)) {

                    $title = $post['Menu']['items'];
                    if ($title) {
                        MenuAuth::deleteAll(['menu_id' => $model->id]);
                        foreach ($title as $key => $val) {
                            $menuAuth = new MenuAuth();
                            $menuAuth->menu_id = $model->id;
                            $menuAuth->item_name = $val;

                            if (($flag = $menuAuth->save(false)) === false) {
                                $transaction->rollBack();
                                break;
                            } else {
                                print_r($menuAuth->getErrors());
                            }
                        }
                    }
                } else {
                    print_r($model->getError());
                    exit();
                }

                if ($flag) {
                    $transaction->commit();
                   // return $this->redirect(['index', /*'id' => $model->id*/]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->renderAjax('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->items = $model->itemAll;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            $model->icon = !empty($post['Menu']['icon']) ? 'menu-icon fa '.$post['Menu']['icon'] : null;
            $model->parent_id = !empty($post['Menu']['parent_id']) ? $post['Menu']['parent_id'] : '0';
            $model->created_at = time();
            $model->created_by = Yii::$app->user->id;
            $model->params = $post['Menu']['params'] ? Json::decode($post['Menu']['params']) : null;
            $transaction = \Yii::$app->db->beginTransaction();
            try {

                if ($flag = $model->save(false)) {

                    $title = $post['Menu']['items'];
                    if ($title) {
                        MenuAuth::deleteAll(['menu_id' => $model->id]);
                        foreach ($title as $key => $val) {
                            $menuAuth = new MenuAuth();
                            $menuAuth->menu_id = $model->id;
                            $menuAuth->item_name = $val;

                            if (($flag = $menuAuth->save(false)) === false) {
                                $transaction->rollBack();
                                break;
                            } else {
                                print_r($menuAuth->getErrors());
                            }
                        }
                    }
                } else {
                    print_r($model->getError());
                    exit();
                }

                if ($flag) {
                    $transaction->commit();
                    echo '1';
                    //return $this->redirect(['index', /*'id' => $model->id*/]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        $model->params = $model->params ? Json::encode($model->params) : null;
        return $this->renderAjax('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
