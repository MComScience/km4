<?php

namespace app\modules\Inventory\models;

use Yii;

class TbGenericproductGp extends \yii\db\ActiveRecord
{
    const YES = '1';
    const NO = '0';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_genericproduct_gp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_GP','DrugGroup_GP','ISED_CatID'], 'required'],
            [['TMTID_GP', 'HighDrugAlertType', 'TMTID_VTM_GP', 'SubClass_GP', 'DrugGroup_GP', 'ISED_CatID', 'PregCatID_GP'], 'integer'],
            [['FNS_GP'], 'string', 'max' => 2000],
            [['StrNum_GP', 'StrUnit_GP', 'StrDeno_GP', 'StrDenUnit_GP'], 'string', 'max' => 20],
            [['DOSAGEFORM_GP', 'Class_GP'], 'string', 'max' => 100],
            [['CHANGEDATE_GP'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_GP' => Yii::t('app', 'Tmtid  Gp'),
            'FNS_GP' => Yii::t('app', 'Fns  Gp'),
            'HighDrugAlertType' => Yii::t('app', 'เป็นยาในกลุ่ม high drug alert?'),
            'TMTID_VTM_GP' => Yii::t('app', 'Tmtid  Vtm  Gp'),
            'StrNum_GP' => Yii::t('app', 'Str Num  Gp'),
            'StrUnit_GP' => Yii::t('app', 'Str Unit  Gp'),
            'StrDeno_GP' => Yii::t('app', 'Str Deno  Gp'),
            'StrDenUnit_GP' => Yii::t('app', 'Str Den Unit  Gp'),
            'DOSAGEFORM_GP' => Yii::t('app', 'Dosageform  Gp'),
            'Class_GP' => Yii::t('app', 'กลุ่มยา'),
            'SubClass_GP' => Yii::t('app', 'กลุ่มยาย่อย'),
            'DrugGroup_GP' => Yii::t('app', 'บัญชียา'),
            'CHANGEDATE_GP' => Yii::t('app', 'Changedate  Gp'),
            'ISED_CatID' => Yii::t('app', 'บัญชียาหลักแห่งชาติ'),
            'PregCatID_GP' => Yii::t('app', 'ระดับผลการใช้ยาหญิงมีครรค์'),
        ];
    }
    
    public function getHighDrugAlertType() {
        return self::itemsAlias('HighDrugAlertType');
    }
    
     public static function itemsAlias($key){

      $items = [
        'HighDrugAlertType'=>[
          self::YES => 'Yes',
          self::NO=> 'No'
        ],
    ];
      return \yii\helpers\ArrayHelper::getValue($items,$key,[]);
      //return array_key_exists($key, $items) ? $items[$key] : [];
    }
}
