<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_rating_vendor".
 *
 * @property integer $id
 * @property integer $rating
 */
class Tbratingvendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_rating_vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rating'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating' => 'Rating',
        ];
    }
}
