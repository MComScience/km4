<?php

namespace frontend\controllers;

use Yii;
use app\models\TbProblem;
use app\models\TbProblemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\models\Uploads;
use app\models\LineBot;

/**
 * NotifyController implements the CRUD actions for TbProblem model.
 */
class NotifyController extends Controller {

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
     * Lists all TbProblem models.
     * @return mixed
     */
    public function actionIndex() {
        //$searchModel = new TbProblemSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = TbProblem::find()->orderBy('status ASC')->all();

        return $this->render('index', [
                    'model' => $model,
                        //'searchModel' => $searchModel,
                        //'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbProblem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TbProblem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new TbProblem();

        if ($model->load(Yii::$app->request->post())) {

            $this->Uploads(false);
            $model->create_by = \Yii::$app->user->getId();
            $model->create_date = date('Y-m-d H:i:s');
            $model->status = 1;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Success!');
                return $this->redirect(['create']);
            }
        } else {
            $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(), 10);
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TbProblem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->ref);

        if ($model->load(Yii::$app->request->post())) {
            $this->Uploads(false);

            $model->update_by = \Yii::$app->user->getId();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Update Success!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'initialPreview' => $initialPreview,
                    'initialPreviewConfig' => $initialPreviewConfig
        ]);
    }

    /**
     * Deletes an existing TbProblem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    /**
     * Finds the TbProblem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TbProblem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TbProblem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUploadAjax() {
        $this->Uploads(true);
    }

    private function Uploads($isAjax = false) {
        if (Yii::$app->request->isPost) {
            $images = UploadedFile::getInstancesByName('upload_ajax');
            if ($images) {

                if ($isAjax === true) {
                    $ref = Yii::$app->request->post('ref');
                } else {
                    $TbProblem = Yii::$app->request->post('TbProblem');
                    $ref = $TbProblem['ref'];
                }

                $this->CreateDir($ref);

                foreach ($images as $file) {
                    $fileName = $file->baseName . '.' . $file->extension;
                    $realFileName = md5($file->baseName . time()) . '.' . $file->extension;
                    $savePath = TbProblem::UPLOAD_FOLDER . '/' . $ref . '/' . $realFileName;
                    if ($file->saveAs($savePath)) {

                        if ($this->isImage(Url::base(true) . '/' . $savePath)) {
                            $this->createThumbnail($ref, $realFileName);
                        }

                        $model = new Uploads;
                        $model->ref = $ref;
                        $model->file_name = $fileName;
                        $model->real_filename = $realFileName;
                        $model->save();

                        if ($isAjax === true) {
                            echo json_encode(['success' => 'true']);
                        }
                    } else {
                        if ($isAjax === true) {
                            echo json_encode(['success' => 'false', 'eror' => $file->error]);
                        }
                    }
                }
            }
        }
    }

    private function CreateDir($folderName) {
        if ($folderName != NULL) {
            $basePath = TbProblem::getUploadPath();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
                BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    private function getInitialPreview($ref) {
        $datas = Uploads::find()->where(['ref' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview, $this->getTemplatePreview($value));
            array_push($initialPreviewConfig, [
                'caption' => $value->file_name,
                'width' => '120px',
                'url' => Url::to(['/notify/deletefile-ajax']),
                'key' => $value->upload_id
            ]);
        }
        return [$initialPreview, $initialPreviewConfig];
    }

    public function isImage($filePath) {
        return @is_array(getimagesize($filePath)) ? true : false;
    }

    private function getTemplatePreview(Uploads $model) {
        $filePath = TbProblem::getUploadUrl() . $model->ref . '/thumbnail/' . $model->real_filename;
        $isImage = $this->isImage($filePath);
        if ($isImage) {
            $file = Html::img($filePath, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
        } else {
            $file = "<div class='file-preview-other'> " .
                    "<h2><i class='glyphicon glyphicon-file'></i></h2>" .
                    "</div>";
        }
        return $file;
    }

    private function createThumbnail($folderName, $fileName, $width = 250) {
        $uploadPath = TbProblem::getUploadPath() . '/' . $folderName . '/';
        $file = $uploadPath . $fileName;
        $image = Yii::$app->image->load($file);
        $image->resize($width);
        $image->save($uploadPath . 'thumbnail/' . $fileName);
        return;
    }

    public function actionDeletefileAjax() {

        $model = Uploads::findOne(Yii::$app->request->post('key'));
        if ($model !== NULL) {
            $filename = TbProblem::getUploadPath() . $model->ref . '/' . $model->real_filename;
            $thumbnail = TbProblem::getUploadPath() . $model->ref . '/thumbnail/' . $model->real_filename;
            if ($model->delete()) {
                @unlink($filename);
                @unlink($thumbnail);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }

    private function removeUploadDir($dir) {
        BaseFileHelper::removeDirectory(TbProblem::getUploadPath() . $dir);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        //remove upload file & data
        $this->removeUploadDir($model->ref);
        Uploads::deleteAll(['ref' => $model->ref]);

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionCurl() { /*     * ส่งจาก Forum */
        $last_thread = LineBot::findOne(['type' => 'forum']);
        //$thread = Thread::find()->orderBy(['id' => SORT_DESC])->one();
        if (!$last_thread) {
            $last_thread = new LineBot();
            $last_thread->type = 'forum';
            $last_thread->last_id = 144;
            $last_thread->save();
            $message = 'ทดสอบ Line Bot http://www.udcancer.org/km4/user/login';
            $res = $this->notify_message($message);
        } else {
            if ($last_thread->last_id != 144) {
                $message = 'ทดสอบ Line Bot http://www.udcancer.org/km4/user/login';
                $res = $this->notify_message($message);
                $last_thread->last_id = 144;
                $last_thread->save();
            }
        }
    }

    public function notify_message($message) {
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'aNxhxB7hJQOMcdbYjVrVF0xqAm8tRJUYgWG6Ck1hI4O';
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array('http' => array('method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n" . "Authorization: Bearer " . $line_token . "\r\n" . "Content-Length: " . strlen($queryData) . "\r\n", 'content' => $queryData));
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }

}
