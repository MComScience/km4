<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\themes\beyond\controllers;

use Yii;
use dektrium\user\filters\AccessRule;
use dektrium\user\Finder;
use dektrium\user\models\Profile;
use dektrium\user\models\User;
use dektrium\user\models\UserSearch;
use dektrium\user\Module;
use dektrium\user\traits\EventTrait;
use yii\base\ExitException;
use yii\base\Model;
use yii\base\Module as Module2;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use dektrium\user\models\Amphur;
use dektrium\user\models\District;
use yii\helpers\Json;
use yii\helpers\BaseFileHelper;
use dektrium\user\controllers\AdminController as BaseAdminController;

/**
 * AdminController allows you to administrate users.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends BaseAdminController {

    use EventTrait;

    /**
     * Event is triggered before creating new user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CREATE = 'beforeCreate';

    /**
     * Event is triggered after creating new user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CREATE = 'afterCreate';

    /**
     * Event is triggered before updating existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_UPDATE = 'beforeUpdate';

    /**
     * Event is triggered after updating existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    /**
     * Event is triggered before updating existing user's profile.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_PROFILE_UPDATE = 'beforeProfileUpdate';

    /**
     * Event is triggered after updating existing user's profile.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_PROFILE_UPDATE = 'afterProfileUpdate';

    /**
     * Event is triggered before confirming existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

    /**
     * Event is triggered after confirming existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    /**
     * Event is triggered before deleting existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_DELETE = 'beforeDelete';

    /**
     * Event is triggered after deleting existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_DELETE = 'afterDelete';

    /**
     * Event is triggered before blocking existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_BLOCK = 'beforeBlock';

    /**
     * Event is triggered after blocking existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_BLOCK = 'afterBlock';

    /**
     * Event is triggered before unblocking existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_UNBLOCK = 'beforeUnblock';

    /**
     * Event is triggered after unblocking existing user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_UNBLOCK = 'afterUnblock';

    /** @var Finder */
    protected $finder;

    /**
     * @param string  $id
     * @param Module2 $module
     * @param Finder  $finder
     * @param array   $config
     */
    /*
    public function __construct($id, $module, Finder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }*/

    /** @inheritdoc */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'confirm' => ['post'],
                    'block' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                        [
                        'allow' => true,
                        'roles' => ['admin', 'SuperAdmin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex() {
        Url::remember('', 'actions-redirect');
        $searchModel = Yii::createObject(UserSearch::className());
        $dataProvider = $searchModel->searchusers(Yii::$app->request->get());
        $dataProvider->pagination->pageSize = false;
        //$searchModel  = Yii::createObject(UserSearch::className());
        ///$dataProvider = $searchModel->search(Yii::$app->request->get());

        $fkey = [];
        $sum = [];
        if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            ini_set('memory_limit', '256M');

            $excel_file = UploadedFile::getInstanceByName('excel_file');

            $newFileName = 'userlist_' . date("Ymd_His") . '_' . $excel_file->name;
            $fullPath = Yii::$app->basePath . '/web/uploads/' . $newFileName;

            $excel_file->saveAs($fullPath);

            if ($excel_file) {
                try {
                    $inputFileType = \PHPExcel_IOFactory::identify($fullPath);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($fullPath);

                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    $sum['fsum'] = 0;
                    $sum['tsum'] = 0;
                    $sum['ksum'] = 0;
                    $sum['all'] = 0;
                    for ($row = 2; $row <= $highestRow; $row++) {

                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, FALSE, FALSE);

                        $data = $rowData[0];
                        if (isset($data[0]) && $data[0] != '') {
                            $sum['all'] ++;

                            $check = User::find()->where('username=:User_fname', [':User_fname' => $data[0]])->count();
                            if ($check > 0) {
                                $fkey[] = $data[0];
                                $sum['ksum'] ++;
                                continue;
                            }

                            $model = new Profile();
                            $model->User_jobid = $data[6];
                            $model->User_title = $data[2];
                            $model->User_fname = $data[3];
                            $model->User_lname = $data[4];
                            $model->User_email = $data[5];
                            $model->UserCatID = 1;

                            if ($model->validate()) {
                                $user = new User();
                                $user->username = $data[0];
                                $user->email = isset($model->public_email) && !empty($model->public_email) ? $model->public_email : $data[5];
                                $user->password = $data[1];
                                $user->password_repeat = $data[1];

                                $user->setScenario('create');
                                $user->setProfile($model);
                                if ($user->create()) {
                                    $manager = Yii::$app->getAuthManager();
                                    $items = ['User', 'menuleft'];
                                    foreach ($items as $name) {
                                        //  $auth->assign($auth->getRole($name), $user->getId());
                                        try {
                                            $item = $manager->getRole($name);
                                            $item = $item ?: $manager->getPermission($name);
                                            $manager->assign($item, $user->getId());
                                        } catch (\Exception $exc) {
                                            Yii::error($exc->getMessage(), __METHOD__);
                                        }
                                    }
                                    $sum['tsum'] ++;
                                } else {
                                    $sum['fsum'] ++;
                                }
                            }
                        }
                    }
                    @unlink($fullPath);
                } catch (\yii\base\Exception $e) {
                    echo 'Error loading file';
                }
            }
        }

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'fkey' => $fkey,
                    'sum' => $sum,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    /*
    public function actionCreate() {
        $user = Yii::createObject([
                    'class' => User::className(),
                    'scenario' => 'create',
        ]);
        //$event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        //$this->trigger(self::EVENT_BEFORE_CREATE, $event);

        $model = new \dektrium\user\models\Profile();
        $model->UserCatID = 1;

        $user->setScenario('create');
        $user->setProfile($model);
        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            $manager = Yii::$app->getAuthManager();
            $items = ['User', 'menuleft'];
            foreach ($items as $name) {
                //  $auth->assign($auth->getRole($name), $user->getId());
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->assign($item, $user->getId());
                } catch (\Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }
            $profile = Profile::findOne($user->getId());
            $profile->User_email = $_POST['User']['email'];
            $profile->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been created'));
            //$this->trigger(self::EVENT_AFTER_CREATE, $event);
            return $this->redirect(['update', 'id' => $user->id]);
        }

        return $this->render('create', [
                    'user' => $user,
                    'scenario' => 'create'
        ]);
    }*/

    /**
     * Updates an existing User model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id) {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('_account', [
                    'user' => $user,
                    'scenario' => $user->scenario
        ]);
    }

    /**
     * Updates an existing profile.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdateProfile($id) {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $profile = $user->profile;
        $event = $this->getProfileEvent($profile);

        if ($profile == null) {
            $profile = Yii::createObject(Profile::className());
            $profile->link('user', $user);
        }

        $this->performAjaxValidation($profile);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);

        $tempDocs = $profile->profileimg;
        if ($profile->load(Yii::$app->request->post())) {
            $this->CreateDir($profile->ref);
            if ($profile->UserCatID == 2) {
                $user->email = $profile->VenderEmail;
            } else {
                $user->email = $profile->User_email;
            }
            $profile->profileimg = $this->uploadMultipleFile($profile, $tempDocs);
            $profile->User_citizentid = empty($_POST['Profile']['User_citizentid']) ? NULL : str_replace('-', '', $_POST['Profile']['User_citizentid']);
            $profile->User_mobilephone = empty($_POST['Profile']['User_mobilephone']) ? NULL : str_replace('-', '', $_POST['Profile']['User_mobilephone']);
            $profile->User_phone = empty($_POST['Profile']['User_phone']) ? NULL : str_replace('-', '', $_POST['Profile']['User_phone']);
            $profile->save();
            $user->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile details have been updated'));
            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
            return $this->refresh();
        }
        if ($profile->ref == NULL) {
            $profile->ref = substr(Yii::$app->getSecurity()->generateRandomString(), 10);
        }
        if ($profile->UserCatID == 2) {
            $amphur = ArrayHelper::map($this->getAmphur($profile->VendorProvince), 'id', 'name');
            $district = ArrayHelper::map($this->getDistrict($profile->VenderDistct), 'id', 'name');
            //$zipcode = ArrayHelper::map($this->getZipcode($profile->VenderPostalCode), 'id', 'name');
        } else {
            $amphur = ArrayHelper::map($this->getAmphur($profile->User_province), 'id', 'name');
            $district = ArrayHelper::map($this->getDistrict($profile->User_distct), 'id', 'name');
            //$zipcode = ArrayHelper::map($this->getZipcode($profile->User_postalcode), 'id', 'name');
        }
        return $this->render('_profile', [
                    'user' => $user,
                    'profile' => $profile,
                    'amphur' => $amphur,
                    'district' => $district,
                        // 'zipcode' => $zipcode,
        ]);
    }

    /**
     * Shows information about user.
     *
     * @param int $id
     *
     * @return string
     */
    public function actionInfo($id) {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        return $this->render('_info', [
                    'user' => $user,
        ]);
    }

    /**
     * If "dektrium/yii2-rbac" extension is installed, this page displays form
     * where user can assign multiple auth items to user.
     *
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAssignments($id) {
        if (!isset(\Yii::$app->extensions['dektrium/yii2-rbac'])) {
            throw new NotFoundHttpException();
        }
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);

        return $this->render('_assignments', [
                    'user' => $user,
        ]);
    }

    /**
     * Confirms the User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function actionConfirm($id) {
        $model = $this->findModel($id);
        $event = $this->getUserEvent($model);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $model->confirm();
        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been confirmed'));

        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id) {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not remove your own account'));
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);
            $model->delete();
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been deleted'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Blocks the user.
     *
     * @param int $id
     *
     * @return Response
     */
    public function actionBlock($id) {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not block your own account'));
        } else {
            $user = $this->findModel($id);
            $event = $this->getUserEvent($user);
            if ($user->getIsBlocked()) {
                $this->trigger(self::EVENT_BEFORE_UNBLOCK, $event);
                $user->unblock();
                $this->trigger(self::EVENT_AFTER_UNBLOCK, $event);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been unblocked'));
            } else {
                $this->trigger(self::EVENT_BEFORE_BLOCK, $event);
                $user->block();
                $this->trigger(self::EVENT_AFTER_BLOCK, $event);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
            }
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $user = $this->finder->findUserById($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

    /**
     * Performs AJAX validation.
     *
     * @param array|Model $model
     *
     * @throws ExitException
     */
    protected function performAjaxValidation($model) {
        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax) {
            if ($model->load(\Yii::$app->request->post())) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                \Yii::$app->end();
            }
        }
    }

    public function actionGetAmphur() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getAmphur($province_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetDistrict() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            if ($province_id != null) {
                $data = $this->getDistrict($amphur_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionGetZipcode() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $province_id = empty($ids[0]) ? null : $ids[0];
            $amphur_id = empty($ids[1]) ? null : $ids[1];
            $zipcode_id = empty($ids[2]) ? null : $ids[2];
            if ($province_id != null) {
                $data = $this->getZipcode($zipcode_id);
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    protected function getAmphur($id) {
        $datas = Amphur::find()->where(['PROVINCE_ID' => $id])->all();
        return $this->MapData($datas, 'AMPHUR_ID', 'AMPHUR_NAME');
    }

    protected function getDistrict($id) {
        $datas = District::find()->where(['AMPHUR_ID' => $id])->all();
        return $this->MapData($datas, 'DISTRICT_ID', 'DISTRICT_NAME');
    }

    protected function getZipcode($id) {
        $datas = Zipcode::find()->where(['DISTRICT_ID' => $id])->all();
        return $this->MapData($datas, 'DISTRICT_ID', 'ZIPCODE');
    }

    protected function MapData($datas, $fieldId, $fieldName) {
        $obj = [];
        foreach ($datas as $key => $value) {
            array_push($obj, ['id' => $value->{$fieldId}, 'name' => $value->{$fieldName}]);
        }
        return $obj;
    }

    public function actionZipcodeList($q = null) {
        $query = new \yii\db\Query;

        $query->select('ZIPCODE')
                ->from('zipcode')
                ->where('ZIPCODE LIKE "%' . $q . '%"')
                ->groupBy('ZIPCODE');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = $d['ZIPCODE'];
        }
        return Json::encode($out);
    }

    private function uploadMultipleFile($profile, $tempFile = null) {
        $files = [];
        $json = '';
        $tempFile = Json::decode($tempFile);
        $UploadedFiles = UploadedFile::getInstances($profile, 'profileimg');
        if ($UploadedFiles !== null) {
            foreach ($UploadedFiles as $file) {
                try {
                    $oldFileName = $file->basename . '.' . $file->extension;
                    $newFileName = md5($file->basename . time()) . '.' . $file->extension;
                    $file->saveAs(Profile::UPLOAD_FOLDER . '/' . $profile->ref . '/' . $newFileName);
                    $files[$newFileName] = $oldFileName;
                } catch (Exception $e) {
                    
                }
            }
            $json = json::encode(ArrayHelper::merge($tempFile, $files));
        } else {
            $json = $tempFile;
        }
        return $json;
    }

    private function CreateDir($folderName) {
        if ($folderName != NULL) {
            $basePath = Profile::getUploadPath();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
                //BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    private function deleteFile($type = 'file', $ref, $fileName) {
        if (in_array($type, ['file', 'thumbnail'])) {
            if ($type === 'file') {
                $filePath = Profile::getUploadPath() . $ref . '/' . $fileName;
            } else {
                $filePath = Profile::getUploadPath() . $ref . '/thumbnail/' . $fileName;
            }
            @unlink($filePath);
            return true;
        } else {
            return false;
        }
    }

    public function actionDeletefile($id, $field, $fileName) {
        $status = ['success' => false];
        if (in_array($field, ['profileimg'])) {
            $model = Profile::findOne($id);
            $files = Json::decode($model->{$field});
            if (array_key_exists($fileName, $files)) {
                if ($this->deleteFile('file', $model->ref, $fileName)) {
                    $status = ['success' => true];
                    unset($files[$fileName]);
                    $model->{$field} = Json::encode($files);
                    $model->save();
                }
            }
        }
        echo json_encode($status);
    }

    public function actionDeleteVender() {
        $id = $_POST['id'];
        if ($id == Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', Yii::t('user', 'You can not remove your own account'));
        } else {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been deleted'));
        }
    }
}
