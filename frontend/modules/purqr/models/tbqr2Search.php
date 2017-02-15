<?php

namespace app\modules\purqr\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\purqr\models\tbqr2;

/**
 * tbqr2Search represents the model behind the search form about `app\modules\purqr\models\tbqr2`.
 */
class tbqr2Search extends tbqr2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['QRID', 'POTypeID', 'QRcreateby', 'QRStatus'], 'integer'],
            [['QRNum', 'QRDate', 'QRExpectDate', 'QRsenddate', 'QRmassage'], 'safe'],
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
        $query = tbqr2::find();

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
            'POTypeID' => $this->POTypeID,
            'QRExpectDate' => $this->QRExpectDate,
            'QRcreateby' => $this->QRcreateby,
            'QRStatus' => $this->QRStatus,
            'QRsenddate' => $this->QRsenddate,
        ]);

        $query->andFilterWhere(['like', 'QRNum', $this->QRNum])
            ->andFilterWhere(['like', 'QRmassage', $this->QRmassage]);

        return $dataProvider;
    }
}
