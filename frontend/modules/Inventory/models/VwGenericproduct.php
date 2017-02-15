<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "vw_genericproduct".
 *
 * @property integer $TMTID_GPU
 * @property string $FSN_GPU
 * @property string $FNS_GP
 * @property string $FNS_GPU_label
 * @property string $Class_GP
 * @property string $DrugClass
 * @property integer $SubClass_GP
 * @property string $DrugSubClass
 * @property integer $DrugGroup_GP
 * @property string $druggroup
 * @property integer $ISED_CatID
 * @property string $ISED
 * @property integer $PregCatID_GP
 * @property string $PregCat
 * @property integer $HighDrugAlertType
 * @property string $Dosageform_GPU
 * @property string $StrNum_GPU
 * @property string $ContVal_GPU
 * @property string $CoutUnit_GPU
 * @property string $ContUnit
 * @property string $DispUnit_GPU
 * @property string $DispUnit
 * @property integer $TMTID_GP
 * @property integer $DrugClassID
 * @property integer $DrugSubClassID
 * @property integer $druggroupID
 * @property integer $ISEDID
 * @property integer $PregCatID
 * @property integer $DispUnitID
 * @property integer $ContUnitID
 */
class VwGenericproduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vw_genericproduct';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GPU', 'SubClass_GP', 'DrugGroup_GP', 'ISED_CatID', 'PregCatID_GP', 'HighDrugAlertType', 'TMTID_GP', 'DrugClassID', 'DrugSubClassID', 'druggroupID', 'ISEDID', 'PregCatID', 'DispUnitID', 'ContUnitID'], 'integer'],
            [['FSN_GPU'], 'string'],
            [['FNS_GP'], 'string', 'max' => 2000],
            [['FNS_GPU_label', 'Dosageform_GPU', 'StrNum_GPU'], 'string', 'max' => 255],
            [['Class_GP'], 'string', 'max' => 100],
            [['DrugClass', 'DrugSubClass', 'druggroup', 'ContVal_GPU', 'CoutUnit_GPU', 'DispUnit_GPU'], 'string', 'max' => 50],
            [['ISED', 'PregCat', 'ContUnit', 'DispUnit'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GPU' => Yii::t('app', 'Tmtid  Gpu'),
            'FSN_GPU' => Yii::t('app', 'Fsn  Gpu'),
            'FNS_GP' => Yii::t('app', 'Fns  Gp'),
            'FNS_GPU_label' => Yii::t('app', 'Fns  Gpu Label'),
            'Class_GP' => Yii::t('app', 'Class  Gp'),
            'DrugClass' => Yii::t('app', 'Drug Class'),
            'SubClass_GP' => Yii::t('app', 'Sub Class  Gp'),
            'DrugSubClass' => Yii::t('app', 'Drug Sub Class'),
            'DrugGroup_GP' => Yii::t('app', 'Drug Group  Gp'),
            'druggroup' => Yii::t('app', 'Druggroup'),
            'ISED_CatID' => Yii::t('app', 'Ised  Cat ID'),
            'ISED' => Yii::t('app', 'Ised'),
            'PregCatID_GP' => Yii::t('app', 'Preg Cat Id  Gp'),
            'PregCat' => Yii::t('app', 'Preg Cat'),
            'HighDrugAlertType' => Yii::t('app', 'เป็นยาในกลุ่ม high drug alert?'),
            'Dosageform_GPU' => Yii::t('app', 'Dosageform  Gpu'),
            'StrNum_GPU' => Yii::t('app', 'Str Num  Gpu'),
            'ContVal_GPU' => Yii::t('app', 'Cont Val  Gpu'),
            'CoutUnit_GPU' => Yii::t('app', 'Cout Unit  Gpu'),
            'ContUnit' => Yii::t('app', 'หน่วยของบรรจุภัณฑ์'),
            'DispUnit_GPU' => Yii::t('app', 'Disp Unit  Gpu'),
            'DispUnit' => Yii::t('app', 'Disp Unit'),
            'TMTID_GP' => Yii::t('app', 'Tmtid  Gp'),
            'DrugClassID' => Yii::t('app', 'Drug Class ID'),
            'DrugSubClassID' => Yii::t('app', 'Drug Sub Class ID'),
            'druggroupID' => Yii::t('app', 'Druggroup ID'),
            'ISEDID' => Yii::t('app', 'Isedid'),
            'PregCatID' => Yii::t('app', 'Preg Cat ID'),
            'DispUnitID' => Yii::t('app', 'Disp Unit ID'),
            'ContUnitID' => Yii::t('app', 'Cont Unit ID'),
        ];
    }
}
