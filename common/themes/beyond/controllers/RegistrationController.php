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

use dektrium\user\Finder;
use dektrium\user\models\RegistrationForm;
use dektrium\user\models\ResendForm;
use dektrium\user\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
/**
 * RegistrationController is responsible for all registration process, which includes registration of a new account,
 * resending confirmation tokens, email confirmation and registration via social networks.
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RegistrationController extends BaseRegistrationController {

    use AjaxValidationTrait;
    use EventTrait;

    /**
     * Event is triggered after creating RegistrationForm class.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_REGISTER = 'beforeRegister';

    /**
     * Event is triggered after successful registration.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_REGISTER = 'afterRegister';

    /**
     * Event is triggered before connecting user to social account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONNECT = 'beforeConnect';

    /**
     * Event is triggered after connecting user to social account.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONNECT = 'afterConnect';

    /**
     * Event is triggered before confirming user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_BEFORE_CONFIRM = 'beforeConfirm';

    /**
     * Event is triggered before confirming user.
     * Triggered with \dektrium\user\events\UserEvent.
     */
    const EVENT_AFTER_CONFIRM = 'afterConfirm';

    /**
     * Event is triggered after creating ResendForm class.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_BEFORE_RESEND = 'beforeResend';

    /**
     * Event is triggered after successful resending of confirmation email.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_RESEND = 'afterResend';

    /** @var Finder */
    protected $finder;
    
    const EVENT_BEFORE_UNBLOCK = 'beforeUnblock';
    
    const EVENT_AFTER_UNBLOCK = 'afterUnblock';
    
    const EVENT_BEFORE_BLOCK = 'beforeBlock';
    
    const EVENT_AFTER_BLOCK = 'afterBlock';

    /**
     * @param string           $id
     * @param \yii\base\Module $module
     * @param Finder           $finder
     * @param array            $config
     */
    public function __construct($id, $module, Finder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($id, $module, $config);
    }

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        ['allow' => true, 'actions' => ['register', 'connect', 'index','blocksys','confirm-users'], 'roles' => ['@']],
                        ['allow' => true, 'actions' => ['confirm', 'resend'], 'roles' => ['?', '@']],
                ],
            ],
        ];
    }

    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister() {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $profile = new \dektrium\user\models\Profile();

        // $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $query = User::findOne(['username' => $_POST['register-form']['username']]);
            $id = $query['id'];

            $manager = Yii::$app->getAuthManager();
            $items = ['Vendors', 'menuleft'];
            foreach ($items as $name) {
                //  $auth->assign($auth->getRole($name), $user->getId());
                try {
                    $item = $manager->getRole($name);
                    $item = $item ?: $manager->getPermission($name);
                    $manager->assign($item, $id);
                } catch (\Exception $exc) {
                    Yii::error($exc->getMessage(), __METHOD__);
                }
            }

            $VenderTaxID = $_POST['Profile']['VenderTaxID'];
            $VenderName = $_POST['Profile']['VenderName'];
            $VenderAddress = $_POST['Profile']['VenderAddress'];
            $VenderSubDistct = empty($_POST['Profile']['VenderSubDistct']) ? NULL : $_POST['Profile']['VenderSubDistct'];
            $VenderDistct = empty($_POST['Profile']['VenderDistct']) ? NULL : $_POST['Profile']['VenderDistct'];
            $VendorProvince = empty($_POST['Profile']['VendorProvince']) ? NULL : $_POST['Profile']['VendorProvince'];
            $VenderPostalCode = empty($_POST['Profile']['VenderPostalCode']) ? NULL : $_POST['Profile']['VenderPostalCode'];
            $VenderPhone = $_POST['Profile']['VenderPhone'];
            $VenderFax = $_POST['Profile']['VenderFax'];
            $VenderContPersonNm = $_POST['Profile']['VenderContPersonNm'];
            $VenderContJobPosition = $_POST['Profile']['VenderContJobPosition'];
            $VenderContMobile = $_POST['Profile']['VenderContMobile'];
            $VenderContEmail = $_POST['Profile']['VenderContEmail'];
            $email = $_POST['register-form']['email'];
            $VenderRating = 1;
            Yii::$app->db->createCommand('CALL cmd_user_register(:x,:VenderTaxID,:VenderName,:VenderAddress,:VenderSubDistct,:VenderDistct,:VendorProvince,:VenderPostalCode,:VenderPhone,:VenderFax,:VenderContPersonNm,:VenderContJobPosition,:VenderContMobile,:VenderContEmail,:VenderRating,:email);')
                    ->bindParam(':x', $id)
                    ->bindParam(':VenderTaxID', $VenderTaxID)
                    ->bindParam(':VenderName', $VenderName)
                    ->bindParam(':VenderAddress', $VenderAddress)
                    ->bindParam(':VenderSubDistct', $VenderSubDistct)
                    ->bindParam(':VenderDistct', $VenderDistct)
                    ->bindParam(':VendorProvince', $VendorProvince)
                    ->bindParam(':VenderPostalCode', $VenderPostalCode)
                    ->bindParam(':VenderPhone', $VenderPhone)
                    ->bindParam(':VenderFax', $VenderFax)
                    ->bindParam(':VenderContPersonNm', $VenderContPersonNm)
                    ->bindParam(':VenderContJobPosition', $VenderContJobPosition)
                    ->bindParam(':VenderContMobile', $VenderContMobile)
                    ->bindParam(':VenderContEmail', $VenderContEmail)
                    ->bindParam(':VenderRating', $VenderRating)
                    ->bindParam(':email', $email)
                    ->execute();
            // $this->trigger(self::EVENT_AFTER_REGISTER, $event);
            return $this->redirect(['index']);
//            return $this->render('/message', [
//                        'title' => Yii::t('user', 'Your account has been created'),
//                        'module' => $this->module,
//            ]);
        }

        return $this->render('register', [
                    'model' => $model,
                    'profile' => $profile,
                    'module' => $this->module,
        ]);
    }

    /**
     * Displays page where user can create new account that will be connected to social account.
     *
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConnect($code) {
        $account = $this->finder->findAccount()->byCode($code)->one();

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = \Yii::createObject([
                    'class' => User::className(),
                    'scenario' => 'connect',
                    'username' => $account->username,
                    'email' => $account->email,
        ]);

        $event = $this->getConnectEvent($account, $user);

        $this->trigger(self::EVENT_BEFORE_CONNECT, $event);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            $account->connect($user);
            $this->trigger(self::EVENT_AFTER_CONNECT, $event);
            \Yii::$app->user->login($user, $this->module->rememberFor);
            return $this->goBack();
        }

        return $this->render('connect', [
                    'model' => $user,
                    'account' => $account,
        ]);
    }

    /**
     * Confirms user's account. If confirmation was successful logs the user and shows success message. Otherwise
     * shows error message.
     *
     * @param int    $id
     * @param string $code
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code) {
        $user = $this->finder->findUserById($id);

        if ($user === null || $this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        $event = $this->getUserEvent($user);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

        $user->attemptConfirmation($code);

        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        return $this->render('/message', [
                    'title' => \Yii::t('user', 'Account confirmation'),
                    'module' => $this->module,
        ]);
    }

    /**
     * Displays page where user can request new confirmation token. If resending was successful, displays message.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionResend() {
        if ($this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }

        /** @var ResendForm $model */
        $model = \Yii::createObject(ResendForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_RESEND, $event);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->resend()) {
            $this->trigger(self::EVENT_AFTER_RESEND, $event);

            return $this->render('/message', [
                        'title' => \Yii::t('user', 'A new confirmation link has been sent'),
                        'module' => $this->module,
            ]);
        }

        return $this->render('resend', [
                    'model' => $model,
        ]);
    }

    public function actionIndex() {
        $searchModel = new \app\models\ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $fkey = [];
        $sum = [];
        if (isset($_FILES['excel_file']['name']) && $_FILES['excel_file']['name'] != '') {
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            ini_set('memory_limit', '256M');

            $excel_file = UploadedFile::getInstanceByName('excel_file');

            $newFileName = 'vendorlist_' . date("Ymd_His") . '_' . $excel_file->name;
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

                            $check = \dektrium\user\models\User::find()->where('username=:User_fname', [':User_fname' => $data[0]])->count();
                            if ($check > 0) {
                                $fkey[] = $data[0];
                                $sum['ksum'] ++;
                                continue;
                            }

                            $model = new \dektrium\user\models\Profile();
                            $model->VenderTaxID = $data[0];
                            $model->VendorID = $data[0];
                            $model->VenderName = $data[1];
                            $model->VenderEmail = $data[2];
                            $model->VenderAddress = $data[3];
                            $model->VenderPhone = str_replace('-', '', $data[4]);
                            $model->VenderFax = str_replace('-', '', $data[5]);
                            $model->UserCatID = 2;


                            if ($model->validate()) {
                                $user = new \dektrium\user\models\User();
                                $user->username = $model->VenderTaxID;
                                $user->email = isset($model->public_email) && !empty($model->public_email) ? $model->public_email : $model->VenderEmail;
                                $user->password = $model->VenderTaxID;
                                $user->password_repeat = $model->VenderTaxID;
                                $user->blocked_sys = time();

                                $user->setScenario('create');
                                $user->setProfile($model);
                                if ($user->create()) {
                                    $manager = Yii::$app->getAuthManager();
                                    $items = ['Vendors', 'menuleft'];
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

    public function actionBlocksys(/* $id */) {
        $id = $_POST['id'];
        if ($id == Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', Yii::t('user', 'You can not block your own account'));
        } else {
            $user = User::findOne($id);
            $event = $this->getUserEvent($user);
            if ($user->getIsBlocked()) {
                $this->trigger(self::EVENT_BEFORE_UNBLOCK, $event);
                $user->unblock();
                $this->trigger(self::EVENT_AFTER_UNBLOCK, $event);
                Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been unblocked'));
            } else {
                $this->trigger(self::EVENT_BEFORE_BLOCK, $event);
                $user->block();
                $this->trigger(self::EVENT_AFTER_BLOCK, $event);
                Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been blocked'));
            }
        }

        return $this->redirect(['index']);
    }
    
    public function actionConfirmUsers($id) {
        $model = User::findOne($id);
        $event = $this->getUserEvent($model);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $model->confirm();
        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been confirmed'));

        return $this->redirect(['index']);
    }

}
