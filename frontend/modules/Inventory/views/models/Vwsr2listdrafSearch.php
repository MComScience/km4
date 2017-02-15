<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Vwsr2listdraf;

/**
 * Vwsr2listdrafSearch represents the model behind the search form about `app\modules\Inventory\models\Vwsr2listdraf`.
 */
class Vwsr2listdrafSearch extends Vwsr2listdraf {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SRNum', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID'], 'integer'],
            [['SRDate', 'DepartmentDesc', 'SectionDecs', 'SRExpectDate', 'stk_issue', 'stk_receive', 'SRStatus', 'SRStatusDesc', 'SRNote', 'q'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Vwsr2listdraf::find();

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
                ->orFilterWhere(['like', 'SRTypeID', $this->q]);

        return $dataProvider;
    }
   

}
