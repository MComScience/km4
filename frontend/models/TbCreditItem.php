<?php

namespace app\models;

use Yii;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_credit_item".
 *
 * @property integer $ids
 * @property integer $ItemID
 * @property string $medical_right_group_id
 * @property integer $maininscl_id
 * @property string $cr_price
 * @property integer $cr_status
 * @property string $cr_effectiveDate
 * @property integer $CreatedBy
 */
class TbCreditItem extends \yii\db\ActiveRecord {

    public $medicalgroup;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tb_credit_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ItemID', 'medical_right_group_id'], 'required'],
            [['ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            //[['cr_price'], 'number'],
            [['cr_effectiveDate', 'cr_price'], 'safe'],
            [['medical_right_group_id'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ids' => 'Ids',
            'ItemID' => 'Item ID',
            'medical_right_group_id' => 'Medical Right Group ID',
            'maininscl_id' => 'Maininscl ID',
            'cr_price' => 'Cr Price',
            'cr_status' => 'Cr Status',
            'cr_effectiveDate' => 'วันที่เริ่มใช้',
            'CreatedBy' => 'Created By',
        ];
    }

    public function getMedical() {
        return $this->hasOne(\app\modules\Inventory\models\Tbmedicalrightgroup::className(), ['medical_right_group_id' => 'medical_right_group_id']);
    }

    public function getFormAttribs() {

        return [
            // primary key column
            'ids' => [// primary key attribute
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
//            'medical_right_group_id' => [
//                'type' => TabularForm::INPUT_TEXT,
//                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER, 'width' => '90px']
//            ],
            'medical_right_group_id' => [
                'label' => '',
                'type' => function($model, $key, $index, $widget) {
                    return ($key % 2 === 0) ? TabularForm::INPUT_HIDDEN : TabularForm::INPUT_WIDGET;
                },
                'type' => TabularForm::INPUT_STATIC,
                'value' => function ($model) {
                    if (!empty($model->medical->medical_right_group)) {
                        return $model->medical->medical_right_group;
                    } else {
                        return '-';
                    }
                },
                'items' => ArrayHelper::map(\app\modules\Inventory\models\Tbmedicalrightgroup::find()->orderBy('medical_right_group')->asArray()->all(), 'medical_right_group_id', 'medical_right_group'),
                'columnOptions' => ['width' => '250px', 'hAlign' => GridView::ALIGN_LEFT, 'noWrap' => true]
            ],
            'cr_price' => [
                'type' => TabularForm::INPUT_WIDGET,
                'label' => 'เบิกได้ตามสิทธิการรักษา',
                'widgetClass' => \yii\widgets\MaskedInput::classname(),
                'options' => function($model, $key, $index, $widget) {
                    return
                            //($key % 2 === 0) ? [] :

                            [
                                'clientOptions' => [
                                    'alias' => 'decimal',
                                    'groupSize' => 3,
                                    'groupSeparator' => ',',
                                    'autoGroup' => true,
                                ],
                                'options' => ['type' => 'textprice', 'class' => 'form-control text-right bg-white'],
                    ];
                },
                        //'options' => ['class' => 'form-control text-right', 'type' => 'textprice'],
                        'columnOptions' => ['hAlign' => GridView::ALIGN_LEFT, 'width' => '50px',],
                    ],
                    'cr_effectiveDate' => [
                        'language' => 'th',
                        'label' => 'วันที่เริ่มใช้',
                        'type' => function($model, $key, $index, $widget) {
                            return TabularForm::INPUT_WIDGET;
                        },
                        'widgetClass' => \yii\jui\DatePicker::classname(),
                        'options' => function($model, $key, $index, $widget) {
                            return
                                    //($key % 2 === 0) ? [] :
                                    [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy', #dd/MM/yyyy
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white;text-align:center',
                                            'type' => 'textdate'
                                        ],
                            ];
                        },
                                'columnOptions' => ['width' => '200px', 'hAlign' => GridView::ALIGN_LEFT,],
                            ],
                        ];
                    }

                }
                