<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_ddi_list".
 *
 * @property integer $Drug1
 * @property string $FNS_VTM1
 * @property integer $Drug2
 * @property string $FNS_VTM2
 * @property integer $DDI_Serverity
 * @property integer $ItemStatus
 * @property string $DDI_Serverity_decs
 */
class Vwddilist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_ddi_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Drug1', 'Drug2', 'DDI_Serverity', 'ItemStatus'], 'integer'],
            [['DDI_Serverity_decs'], 'required'],
            [['FNS_VTM1', 'FNS_VTM2'], 'string', 'max' => 2000],
            [['DDI_Serverity_decs'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Drug1' => Yii::t('app', 'TMTID_VTM1'),
            'FNS_VTM1' => Yii::t('app', 'Fns  Vtm1'),
            'Drug2' => Yii::t('app', 'TMTID_VTM2'),
            'FNS_VTM2' => Yii::t('app', 'Fns  Vtm2'),
            'DDI_Serverity' => Yii::t('app', 'Ddi  Serverity'),
            'ItemStatus' => Yii::t('app', 'Item Status'),
            'DDI_Serverity_decs' => Yii::t('app', 'Ddi  Serverity Decs'),
        ];
    }
}
