<?php

namespace common\themes\beyond\models\log;

use Yii;
use dektrium\user\models\log\LoginForm as BaseLoginForm;
/**
 * This is the model class for table "loginform".
 *
 * @property integer $log_id
 * @property string $username
 * @property string $password
 * @property string $ip
 * @property string $user_agent
 * @property integer $time
 * @property integer $success
 */
class LoginForm extends BaseLoginForm
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loginform';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'ip', 'user_agent'], 'safe'],
            [['time', 'success'], 'integer'],
            [['username', 'password'], 'string', 'max' => 128],
            [['ip'], 'string', 'max' => 16],
            [['user_agent'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'username' => 'Username',
            'password' => 'Password',
            'ip' => 'Ip',
            'user_agent' => 'User Agent',
            'time' => 'Time',
            'success' => 'Success',
        ];
    }
}
