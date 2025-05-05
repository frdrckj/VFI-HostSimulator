<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['id_log', 'log_bulan', 'log_tahun'], 'integer'],
                [['request', 'keterangan_log', 'response', 'date_time_in', 'date_time_out', 'ip_address', 'username', 'action'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Log::find();

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
            'id_log' => $this->id_log,
            'date_time_in' => $this->date_time_in,
//            'date_time_out' => $this->date_time_out,
            'log_bulan' => $this->log_bulan,
            'log_tahun' => $this->log_tahun,
        ]);

        $query->andFilterWhere(['like', 'request', $this->request])
                ->andFilterWhere(['like', 'keterangan_log', $this->keterangan_log])
                ->andFilterWhere(['like', 'response', $this->response])
                ->andFilterWhere(['like', 'ip_address', $this->ip_address])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'action', $this->action])
                ->andFilterWhere(['like', 'date_time_out', $this->date_time_out . '%', false]);

        $query->orderBy(['id_log' => SORT_DESC]);
        return $dataProvider;
    }

}
