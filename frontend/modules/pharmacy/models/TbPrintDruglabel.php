<?php

namespace app\modules\pharmacy\models;

use Yii;

/**
 * This is the model class for table "tb_print_druglabel".
 *
 * @property integer $orderid
 * @property integer $ProfileType
 * @property string $orderdate
 * @property string $orderitem
 * @property string $label1
 * @property string $label2
 * @property string $label3
 * @property string $label4
 * @property string $label5
 * @property string $label6
 * @property string $label7
 * @property string $label8
 * @property string $label9
 * @property string $label10
 * @property string $label11
 * @property string $label12
 * @property integer $stationid
 * @property integer $orderstatus
 */
class TbPrintDruglabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_print_druglabel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid'], 'required'],
            [['orderid', 'ProfileType', 'stationid', 'orderstatus'], 'integer'],
            [['orderdate'], 'safe'],
            [['orderitem', 'label1', 'label2', 'label3', 'label4', 'label5', 'label6', 'label7', 'label8', 'label9', 'label10', 'label11', 'label12'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderid' => 'Orderid',
            'ProfileType' => 'Profile Type',
            'orderdate' => 'Orderdate',
            'orderitem' => 'Orderitem',
            'label1' => 'Label1',
            'label2' => 'Label2',
            'label3' => 'Label3',
            'label4' => 'Label4',
            'label5' => 'Label5',
            'label6' => 'Label6',
            'label7' => 'Label7',
            'label8' => 'Label8',
            'label9' => 'Label9',
            'label10' => 'Label10',
            'label11' => 'Label11',
            'label12' => 'Label12',
            'stationid' => 'Stationid',
            'orderstatus' => 'Orderstatus',
        ];
    }
}
