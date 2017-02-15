<?php

namespace app\modules\Outpatientdepartment\models;

use Yii;

/**
 * This is the model class for table "tb_pt_service_md".
 *
 * @property integer $pt_service_md_id
 * @property string $pt_service_md_name
 */
class TbPtServiceMd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_pt_service_md';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pt_service_md_id'], 'integer'],
            [['pt_service_md_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pt_service_md_id' => 'Pt Service Md ID',
            'pt_service_md_name' => 'Pt Service Md Name',
        ];
    }
}
