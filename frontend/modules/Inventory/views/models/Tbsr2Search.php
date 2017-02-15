<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Tbsr2;

/**
 * Tbsr2Search represents the model behind the search form about `app\modules\Inventory\models\Tbsr2`.
 */
class Tbsr2Search extends Tbsr2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['SRID', 'DepartmentID', 'SectionID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID', 'SRStatus', 'SRCreateBy', 'SRRejectApproveBy'], 'integer'],
            [['SRDate', 'SRNum', 'SRExpectDate', 'SRCreateDate', 'SRApproveBy', 'SRApproveDate', 'SRRejectApproveDate', 'SRNote', 'q'], 'safe'],
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
        $query = Tbsr2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orFilterWhere(['like', 'SRNum', $this->q])
                ->orFilterWhere(['like', 'SRApproveBy', $this->q])
                ->orFilterWhere(['like', 'SRNote', $this->q])
                ->andFilterWhere(['like', 'SRStatus', '2']);

        return $dataProvider;
    }

    public function searchhistory($params) {
        $query = Tbsr2::find();

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
            'SRID' => $this->SRID,
            'SRDate' => $this->SRDate,
            'DepartmentID' => $this->DepartmentID,
            'SectionID' => $this->SectionID,
            'SRTypeID' => $this->SRTypeID,
            'SRExpectDate' => $this->SRExpectDate,
            'SRIssue_stkID' => $this->SRIssue_stkID,
            'SRReceive_stkID' => $this->SRReceive_stkID,
            'SRStatus' => $this->SRStatus,
            'SRCreateBy' => $this->SRCreateBy,
            'SRCreateDate' => $this->SRCreateDate,
            'SRApproveDate' => $this->SRApproveDate,
            'SRRejectApproveBy' => $this->SRRejectApproveBy,
            'SRRejectApproveDate' => $this->SRRejectApproveDate,
        ]);

        $query->andFilterWhere(['like', 'SRNum', $this->SRNum])
                ->andFilterWhere(['like', 'SRApproveBy', $this->SRApproveBy])
                ->andFilterWhere(['like', 'SRNote', $this->SRNote])
                ->andFilterWhere(['like', 'SRStatus', '4']);

        return $dataProvider;
    }

}
