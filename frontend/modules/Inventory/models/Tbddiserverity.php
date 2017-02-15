<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_ddi_serverity".
 *
 * @property integer $ids
 * @property string $DDI_Serverity_decs
 *
 * @property TbDruginteractionLevel[] $tbDruginteractionLevels
 */
class Tbddiserverity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_ddi_serverity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DDI_Serverity_decs'], 'required'],
            [['DDI_Serverity_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ids' => Yii::t('app', 'Ids'),
            'DDI_Serverity_decs' => Yii::t('app', 'Ddi  Serverity Decs'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbDruginteractionLevels()
    {
        return $this->hasMany(TbDruginteractionLevel::className(), ['DDI_Serverity' => 'ids']);
    }
}
