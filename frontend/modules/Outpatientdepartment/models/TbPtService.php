<?php

namespace app\modules\Outpatientdepartment\models;

use Yii;

/**
 * This is the model class for table "tb_pt_service".
 *
 * @property integer $pt_service_id
 * @property string $pt_service_name
 */
class TbPtService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_service_id'], 'integer'],
            [['pt_service_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_service_id' => 'Pt Service ID',
            'pt_service_name' => 'Pt Service Name',
        ];
    }
}
