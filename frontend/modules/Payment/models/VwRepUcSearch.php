<?php

namespace app\modules\Payment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Payment\models\VwRepUc;

/**
 * VwRepUcSearch represents the model behind the search form about `app\modules\Payment\models\VwRepUc`.
 */
class VwRepUcSearch extends VwRepUc
{
    /**
     * @inheritdoc
     */
    public $q;
    public function rules()
    {
        return [
            [['nhso_rep_id'], 'integer'],
            [['invoice_eclaim_num', 'import_by', 'Import_date', 'doc_type', 'User_name','rep','q','itemstatus'], 'safe'],
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
    public function search($params,$type)
    {
        $query = VwRepUc::find();

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
            'rep' => $this->rep,
            'nhso_rep_id' => $this->nhso_rep_id,
            'Import_date' => $this->Import_date,
        ]);
        $type_where = explode("-", $type);
        $query
            ->orFilterWhere(['like', 'rep', $this->q])
            ->orFilterWhere(['like', 'invoice_eclaim_num', $this->q])
            ->orFilterWhere(['like', 'import_by', $this->q])
            ->orFilterWhere(['like', 'User_name', $this->q])
            ->orFilterWhere(['like', 'Import_date', $this->q])
            ->andWhere(['doc_type' => [$type_where[0], $type_where[1]]]);
        if(isset($this->itemstatus)){
            $query->andWhere(['itemstatus' => $this->itemstatus]);
        }
        return $dataProvider;
    }
}
