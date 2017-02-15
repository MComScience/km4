<?php

namespace app\modules\Inventory\models;

use Yii;

/**
 * This is the model class for table "tb_vtm".
 *
 * @property integer $TMTID_VTM
 * @property string $Synonym_VTM
 * @property string $FSN_VTM
 * @property string $CHANGEDATE_VTM
 */
class Tbvtm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_vtm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TMTID_VTM', 'Synonym_VTM', 'FSN_VTM', 'CHANGEDATE_VTM'], 'required'],
            [['TMTID_VTM'], 'integer'],
            [['Synonym_VTM', 'CHANGEDATE_VTM'], 'string', 'max' => 100],
            [['FSN_VTM'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TMTID_VTM' => Yii::t('app', 'Tmtid  Vtm'),
            'Synonym_VTM' => Yii::t('app', 'Synonym  Vtm'),
            'FSN_VTM' => Yii::t('app', 'Fsn  Vtm'),
            'CHANGEDATE_VTM' => Yii::t('app', 'Changedate  Vtm'),
        ];
    }
}
