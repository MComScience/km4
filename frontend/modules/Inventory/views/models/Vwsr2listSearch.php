<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Vwsr2list;

/**
 * Vwsr2listdrafSearch represents the model behind the search form about `app\modules\Inventory\models\Vwsr2listdraf`.
 */
class Vwsr2listSearch extends Vwsr2list
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['SRID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID', 'SRStatus'], 'integer'],
            [['SRDate', 'DepartmentDesc', 'SectionDecs', 'SRExpectDate', 'stk_issue', 'stk_receive', 'SRStatus', 'SRStatusDesc', 'SRNote','q'], 'safe'],
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
        $query = Vwsr2list::find()->where(['SRStatus'=>'2']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'SRNum' => $this->SRNum,
            'SRDate' => $this->SRDate,
            'SRTypeID' => $this->SRTypeID,
            'SRExpectDate' => $this->SRExpectDate,
            'SRIssue_stkID' => $this->SRIssue_stkID,
            'SRReceive_stkID' => $this->SRReceive_stkID,
        ]);

        $query->orFilterWhere(['like', 'SRNum', $this->q])
            ->orFilterWhere(['like', 'SRDate', $this->q])
            ->orFilterWhere(['like', 'stk_issue', $this->q])
            ->orFilterWhere(['like', 'stk_receive', $this->q])
            ->orFilterWhere(['like', 'SRStatus', $this->q])
            ->orFilterWhere(['like', 'SRStatusDesc', $this->q])
            ->orFilterWhere(['like', 'SRNote', $this->q]);

        return $dataProvider;
    }
     public function searchpay($params) {
        $query = Vwsr2list::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'SRNum' => $this->SRNum,
            'SRDate' => $this->SRDate,
            'stk_issue' => $this->stk_issue,
            'stk_receive' => $this->stk_receive,
            'SRTypeID' => $this->SRTypeID,
            'SRStatus' => $this->SRStatus,
        ]);

        $query->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'SRDate', $this->q])
                ->orFilterWhere(['like', 'stk_issue', $this->q])
                ->orFilterWhere(['like', 'stk_receive', $this->q])
                ->orFilterWhere(['like', 'SRStatus', $this->q])
                ->orFilterWhere(['like', 'SRTypeID', $this->q])
                ->andWhere(['SRStatus'=>'approved']);

        return $dataProvider;
    }
     public function searchrecive($params) {
        $query = Vwsr2list::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'SRNum' => $this->SRNum,
            'SRDate' => $this->SRDate,
            'stk_issue' => $this->stk_issue,
            'stk_receive' => $this->stk_receive,
            'SRTypeID' => $this->SRTypeID,
            'SRStatus' => $this->SRStatus,
        ]);

        $query->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'SRDate', $this->q])
                ->orFilterWhere(['like', 'stk_issue', $this->q])
                ->orFilterWhere(['like', 'stk_receive', $this->q])
                ->orFilterWhere(['like', 'SRStatus', $this->q])
                ->orFilterWhere(['like', 'SRTypeID', $this->q])
                ->andWhere(['SRStatus'=>'approved']);

        return $dataProvider;
    }
      public function searchhistory($params) {
        $query = Vwsr2list::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'SRNum' => $this->SRNum,
            'SRDate' => $this->SRDate,
            'stk_issue' => $this->stk_issue,
            'stk_receive' => $this->stk_receive,
            'SRTypeID' => $this->SRTypeID,
            'SRStatus' =>4,
        ]);
//
        $query->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'SRDate', $this->q])
                ->orFilterWhere(['like', 'stk_issue', $this->q])
                ->orFilterWhere(['like', 'stk_receive', $this->q])
                ->orFilterWhere(['like', 'SRStatus', $this->q])
                ->orFilterWhere(['like', 'SRTypeID', $this->q]);
                //->orWhere(['SRStatus'=>'4']);

        return $dataProvider;
    }
}
