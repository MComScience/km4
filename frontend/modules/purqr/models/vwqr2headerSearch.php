<?php

namespace app\modules\purqr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\purqr\models\vwqr2header;

/**
 * vwqr2headerSearch represents the model behind the search form about `app\modules\purqr\models\vwqr2header`.
 */
class vwqr2headerSearch extends vwqr2header
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QRID', 'QRcreateby', 'QRStatus', 'QRDeliveryDay', 'QRValidDay', 'qritemqty'], 'integer'],
            [['QRNum', 'QRDate', 'POType', 'POTypeDesc', 'QRExpectDate', 'QRsenddate', 'QRmassage', 'User_name', 'ItemDetail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = vwqr2header::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'QRID' => $this->QRID,
            'QRDate' => $this->QRDate,
            'QRExpectDate' => $this->QRExpectDate,
            'QRcreateby' => $this->QRcreateby,
            'QRStatus' => $this->QRStatus,
            'QRsenddate' => $this->QRsenddate,
            'QRDeliveryDay' => $this->QRDeliveryDay,
            'QRValidDay' => $this->QRValidDay,
            'qritemqty' => $this->qritemqty,
        ]);

        $query->andFilterWhere(['like', 'QRNum', $this->QRNum])
            ->andFilterWhere(['like', 'POType', $this->POType])
            ->andFilterWhere(['like', 'POTypeDesc', $this->POTypeDesc])
            ->andFilterWhere(['like', 'QRmassage', $this->QRmassage])
            ->andFilterWhere(['like', 'User_name', $this->User_name])
            ->andFilterWhere(['like', 'ItemDetail', $this->ItemDetail]);

        return $dataProvider;
    }
}
