<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace common\themes\beyond\models;

use dektrium\user\Finder;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use dektrium\user\models\UserSearch as BaseUserSearch;
/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends BaseUserSearch {

    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var int */
    public $created_at;

    /** @var string */
    public $registration_ip;

    /** @var Finder */
    protected $finder;

    /**
     * @param Finder $finder
     * @param array  $config
     */
    /*
    public function __construct(Finder $finder, $config = []) {
        $this->finder = $finder;
        parent::__construct($config);
    }*/

    /** @inheritdoc */
    public function rules() {
        return [
            'fieldsSafe' => [['username', 'email', 'registration_ip', 'created_at'], 'safe'],
            'createdDefault' => ['created_at', 'default', 'value' => null],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'created_at' => Yii::t('user', 'Registration time'),
            'registration_ip' => Yii::t('user', 'Registration ip'),
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = $this->finder->getUserQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }

    public function searchusers($params) {
        //$query = User::find();
        $dataProvider = new SqlDataProvider([
            'sql' => "SELECT
                        `user`.id,
                        `user`.username,
                        IFNULL(tb_section.SectionDecs,'-') AS SectionDecs,
                        concat(
                                ifnull(
                                        `tb_pt_titlename`.`pt_titlename`,
                                        ''
                                ),
                                ' ',
                                `profile`.`User_fname`,
                                ' ',
                                `profile`.`User_lname`
                        ) AS User_name,
                        `user`.email,
                        `user`.created_at,
                        `user`.confirmed_at,
                        `user`.LoginStatus,
                        `user`.blocked_at
                        FROM
                            `user`
                        INNER JOIN `profile` ON `profile`.user_id = `user`.id
                        LEFT JOIN tb_pt_titlename ON tb_pt_titlename.pt_titlename_id = `profile`.User_title
                        LEFT JOIN tb_section ON tb_section.SectionID = `profile`.User_sectionid
                        WHERE
                        `profile`.UserCatID = 1",
            'pagination' => [
                'pageSize' => false,
            ],
            'key' => 'id',
        ]);
        /*
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);*/

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        //$query->joinWith('profile');
        /*
        $query->andFilterWhere([
            'username' => $this->username,
            'email' => $this->email,
            'registration_ip' => $this->registration_ip,
        ]);

        $query->orFilterWhere(['like', 'username', $this->username])
                ->orFilterWhere(['like', 'email', $this->email])
                ->orFilterWhere(['like', 'registration_ip', $this->registration_ip])
                ->andWhere(['profile.UserCatID' => 1]);*/

        return $dataProvider;
    }

}
