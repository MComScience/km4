<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_label_drugtpu".
 *
 * @property integer $ItemID
 * @property integer $TMTID_GPU
 * @property string $DrugLabel
 * @property string $DrugAdministration
 * @property string $Druglabel1
 * @property string $Druglabel2
 */
class Vwlabeldrugtpu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_label_drugtpu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ItemID'], 'required'],
            [['ItemID', 'TMTID_GPU'], 'integer'],
            [['DrugAdministration'], 'string'],
            [['DrugLabel'], 'string', 'max' => 300],
            [['Druglabel1', 'Druglabel2'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ItemID' => Yii::t('app', 'รหัสที่ รพ.กำหนด'),
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'DrugLabel' => Yii::t('app', 'Drug Label'),
            'DrugAdministration' => Yii::t('app', 'Drug Administration'),
            'Druglabel1' => Yii::t('app', 'Druglabel1'),
            'Druglabel2' => Yii::t('app', 'Druglabel2'),
        ];
    }
}
