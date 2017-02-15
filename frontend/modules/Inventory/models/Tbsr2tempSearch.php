<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\Tbsr2temp;

/**
 * Tbsr2tempSearch represents the model behind the search form about `app\modules\Inventory\models\Tbsr2temp`.
 */
class Tbsr2tempSearch extends Tbsr2temp
{
    public $q;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SRID', 'DepartmentID', 'SectionID', 'SRTypeID', 'SRIssue_stkID', 'SRReceive_stkID', 'SRStatus', 'SRCreateBy', 'SRRejectApproveBy'], 'integer'],
            [['SRDate', 'SRNum', 'SRExpectDate', 'SRCreateDate', 'SRApproveBy', 'SRApproveDate', 'SRRejectApproveDate', 'SRNote','q'], 'safe'],
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
        $query = Tbsr2temp::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->orFilterWhere(['like', 'SRNum', $this->q])
            ->orFilterWhere(['like', 'SRApproveBy', $this->q])
            ->orFilterWhere(['like', 'SRNote', $this->q]);

        return $dataProvider;
    }
}
