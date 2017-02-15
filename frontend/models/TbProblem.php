<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "tb_problem".
 *
 * @property integer $id
 * @property string $subject
 * @property string $details
 * @property string $ref
 * @property integer $create_by
 * @property integer $update_by
 * @property string $create_date
 * @property integer $status
 */
class TbProblem extends \yii\db\ActiveRecord {

    const UPLOAD_FOLDER = 'uploads';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_problem';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['subject', 'create_by'], 'required'],
                [['details','comment'], 'string'],
                [['create_by', 'update_by', 'status'], 'integer'],
                [['create_date'], 'safe'],
                [['subject'], 'string', 'max' => 255],
                [['ref'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'subject' => 'หัวข้อ/เรื่อง',
            'details' => 'รายละเอียด',
            'ref' => 'Ref',
            'create_by' => 'แจ้งโดย',
            'update_by' => 'Update By',
            'create_date' => 'วันที่แจ้ง',
            'status' => 'Status',
            'comment' => 'Comment',
        ];
    }

    public static function getUploadPath() {
        return Yii::getAlias('@webroot') . '/' . self::UPLOAD_FOLDER . '/';
    }

    public static function getUploadUrl() {
        return Url::base(true) . '/' . self::UPLOAD_FOLDER . '/';
    }

    public function getThumbnails($ref, $event_name) {
        $uploadFiles = Uploads::find()->where(['ref' => $ref])->all();
        $preview = [];
        foreach ($uploadFiles as $file) {
            $preview[] = [
                'url' => self::getUploadUrl(true) . $ref . '/' . $file->real_filename,
                'src' => self::getUploadUrl(true) . $ref . '/thumbnail/' . $file->real_filename,
                'options' => ['title' => $event_name]
            ];
        }
        return $preview;
    }
    
    public function getUser($id){
        if(($model = \dektrium\user\models\Profile::findOne($id)) != null){
            return $model['User_fname'].' '.$model['User_lname'];
        } else {
            return '';
        }
    }

}
