<?php

namespace app\modules\Inventory\models;

use Yii;
use \app\modules\Inventory\models\base\TbCreditItem as BaseTbCreditItem;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_credit_item".
 */
class TbCreditItem extends BaseTbCreditItem {

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_replace_recursive(parent::rules(), [
            [['medical_right_group_id'], 'required'],
           // [['ItemID', 'maininscl_id', 'cr_status', 'CreatedBy'], 'integer'],
            [['cr_price'], 'number'],
            [['cr_effectiveDate','medical_right_group_id'], 'safe'],
            //[['medical_right_group_id'], 'string', 'max' => 50],
//            [['lock'], 'default', 'value' => '0'],
//            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }

    public function getFormAttribs() {
        return [
            // primary key column
            'ItemID' => [// primary key attribute
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            'medical_right_group_id' => [
                'label' => 'ประเภทสิทธิ',
                //'type' => TabularForm::INPUT_TEXT,
                'type' => TabularForm::INPUT_STATIC,
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER, 'width' => '90px']
            ],
            /* 'PRItemAvalible' => [
              'type' => function($model, $key, $index, $widget) {
              return ($key % 2 === 0) ? TabularForm::INPUT_HIDDEN : TabularForm::INPUT_WIDGET;
              },
              'widgetClass' => \yii\widgets\MaskedInput::classname(),
              'options' => function($model, $key, $index, $widget) {
              return ($key % 2 === 0) ? [] :
              [
              'clientOptions' => [
              'alias' => 'decimal',
              'groupSeparator' => ',',
              'autoGroup' => true
              ],
              ];
              },
              'columnOptions' => ['width' => '170px']
              ],
              'color'=>[
              'type'=>TabularForm::INPUT_WIDGET,
              'widgetClass'=>\kartik\widgets\ColorInput::classname(),
              'options'=>[
              'showDefaultPalette'=>false,
              'pluginOptions'=>[
              'preferredFormat'=>'name',
              'palette'=>[
              [
              "white", "black", "grey", "silver", "gold", "brown",
              ],
              [
              "red", "orange", "yellow", "indigo", "maroon", "pink"
              ],
              [
              "blue", "green", "violet", "cyan", "magenta", "purple",
              ],
              ]
              ]
              ],
              'columnOptions'=>['width'=>'150px'],
              ],

              'author_id'=>[
              'type'=>TabularForm::INPUT_DROPDOWN_LIST,
              'items'=>ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
              'columnOptions'=>['width'=>'185px']
              ], */
            'cr_price' => [
                'type' => TabularForm::INPUT_TEXT,
                'label' => 'เบิกได้ตามสิทธิการรักษา',
                'format' => ['decimal', 2],
                'options' => ['class' => 'form-control text-right'],
                'columnOptions' => ['hAlign' => GridView::ALIGN_CENTER, 'width' => '90px']
            ],
            'cr_effectiveDate' => [
                'type' => function($model, $key, $index, $widget) {
                    return ($key % 2 === 0) ? TabularForm::INPUT_HIDDEN : TabularForm::INPUT_WIDGET;
                },
                'language' => Yii::$app->language,
                'widgetClass' => \kartik\widgets\DatePicker::classname(),
                'options' => function($model, $key, $index, $widget) {
                    return ($key % 2 === 0) ? [] :
                            [
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true
                        ]
                    ];
                },
                        'columnOptions' => ['width' => '170px']
                    ],
                ];
            }

        }
        