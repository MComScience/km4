<?php

namespace app\modules\Inventory\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Inventory\models\VwPo2ListForGr2;

/**
 * TbPo2Search represents the model behind the search form about `app\modules\Inventory\models\TbPo2`.
 */
class VwPo2ListForGr2Search extends VwPo2ListForGr2 {

    public $q;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['POID', 'PONum', 'PODate', 'POContID', 'PRNum', 'VendorID', 'POTypeID', 'POType', 'PODueDate', 'VenderName', 'q'], 'safe'],
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
        $query = VwPo2ListForGr2::find();

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
            'POID' => $this->POID,
            'PONum' => $this->PONum,
            'PODate' => $this->PODate,
            'POContID' => $this->POContID,
            'PRNum' => $this->PRNum,
            'VendorID' => $this->VendorID,
            'POTypeID' => $this->POTypeID,
            'POType' => $this->POType,
            'PODueDate' => $this->PODueDate,
            'VenderName' => $this->VenderName,
            'PRTypeID' => $this->PRTypeID,
        ]);

        $query->orFilterWhere(['like', 'POID', $this->q])
                ->orFilterWhere(['like', 'PONum', $this->q])
                ->orFilterWhere(['like', 'PODate', $this->q])
                ->orFilterWhere(['like', 'POContID', $this->q])
                ->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'VendorID', $this->q])
                ->orFilterWhere(['like', 'POTypeID', $this->q])
                ->orFilterWhere(['like', 'POType', $this->q])
                ->orFilterWhere(['like', 'PODueDate', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q]);

        return $dataProvider;
    }

    public function SearchIndexPO($params) {
        $query = VwPo2ListForGr2::find()
        ->select(['*','CONVERT(SUBSTRING_INDEX((SUBSTRING_INDEX(vw_po2_list_for_gr2.PONum,"/",1)),"ย",-1), UNSIGNED INTEGER) AS Asc_PONum'])
        ->orderBy('Asc_PONum ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            
            return $dataProvider;
        }

        $query->andFilterWhere([
            'POID' => $this->POID,
            'PONum' => $this->PONum,
            'PODate' => $this->PODate,
            'POContID' => $this->POContID,
            'PRNum' => $this->PRNum,
            'VendorID' => $this->VendorID,
            'POTypeID' => $this->POTypeID,
            'POType' => $this->POType,
            'PODueDate' => $this->PODueDate,
            'VenderName' => $this->VenderName,
            'PRTypeID' => $this->PRTypeID,
        ]);
        $query->orFilterWhere(['like', 'PONum', $this->q])
                ->orFilterWhere(['like', 'POContID', $this->q])
                ->orFilterWhere(['like', 'PRNum', $this->q])
                ->orFilterWhere(['like', 'VendorID', $this->q])
                ->orFilterWhere(['like', 'POType', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->andWhere(['POStatus' =>11]);
        $array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>Yii::$app->user->identity->profile->User_sectionid])->all();
            if ($array_stk != null) {
                foreach ($array_stk as $data) {
                    $StkID[] = $data['StkID'];
            }
        }
        if(!empty($StkID)){
                $result=array_diff($StkID, array("1001","1002","1003","1004"));
                if(!empty($result)){
                    $query->andWhere(['PRTypeID'=>[3,5,8]]);
                }else{
                    $query->andWhere(['PRTypeID'=>[1,2,4,6,7]]);
                }
        }  
        return $dataProvider;
    }

}
