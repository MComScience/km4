<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Profile;

/**
 * ProfileSearch represents the model behind the search form about `app\models\Profile`.
 */
class ProfileSearch extends Profile {

    /**
     * @inheritdoc
     */
    public $q;
    public $email;

    public function rules() {
        return [
            [['user_id', 'VenderPostalCode', 'CreatedBy', 'UserCatID'], 'integer'],
            [['VendorID', 'email', 'VenderName', 'public_email', 'gravatar_email', 'gravatar_id', 'location', 'website', 'bio', 'VenderAddress', 'VenderSubDistct', 'VenderDistct', 'VendorProvince', 'VenderTaxID', 'VenderPhone', 'VenderFax', 'VenderEmail', 'VenderContPersonNm', 'VenderContJobPosition', 'VenderContMobile', 'VenderContEmail', 'VenderRating', 'CreatedDate', 'CreatedTime', 'profileimg', 'q'], 'safe'],
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
        $query = Profile::find();
        //->where(["UserCatID" => 2]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orFilterWhere([
            'user_id' => $this->user_id,
            'VendorID' => $this->VendorID,
            'VenderName' => $this->VenderName,
            'VenderTaxID' => $this->VenderTaxID,
            'VenderPostalCode' => $this->VenderPostalCode,
            'CreatedBy' => $this->CreatedBy,
            'CreatedDate' => $this->CreatedDate,
            'CreatedTime' => $this->CreatedTime,
            'UserCatID' => $this->UserCatID,
            'email' => $this->email,
        ]);

        $query->orFilterWhere(['like', 'VendorID', $this->q])
                ->orFilterWhere(['like', 'VenderName', $this->q])
                ->andFilterWhere(['like', 'public_email', $this->public_email])
                ->andFilterWhere(['like', 'gravatar_email', $this->gravatar_email])
                ->andFilterWhere(['like', 'gravatar_id', $this->gravatar_id])
                ->andFilterWhere(['like', 'location', $this->location])
                ->andFilterWhere(['like', 'website', $this->website])
                ->andFilterWhere(['like', 'bio', $this->bio])
                ->andFilterWhere(['like', 'VenderAddress', $this->VenderAddress])
                ->andFilterWhere(['like', 'VenderSubDistct', $this->VenderSubDistct])
                ->andFilterWhere(['like', 'VenderDistct', $this->VenderDistct])
                ->andFilterWhere(['like', 'VendorProvince', $this->VendorProvince])
                ->orFilterWhere(['like', 'VenderTaxID', $this->q])
                ->andFilterWhere(['like', 'VenderPhone', $this->VenderPhone])
                ->andFilterWhere(['like', 'VenderFax', $this->VenderFax])
                ->andFilterWhere(['like', 'VenderEmail', $this->VenderEmail])
                ->andFilterWhere(['like', 'VenderContPersonNm', $this->VenderContPersonNm])
                ->andFilterWhere(['like', 'VenderContJobPosition', $this->VenderContJobPosition])
                ->andFilterWhere(['like', 'VenderContMobile', $this->VenderContMobile])
                ->andFilterWhere(['like', 'VenderContEmail', $this->VenderContEmail])
                ->andFilterWhere(['like', 'VenderRating', $this->VenderRating])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andWhere(['UserCatID' => 2])
                ->andFilterWhere(['like', 'profileimg', $this->profileimg]);

        return $dataProvider;
    }

}
