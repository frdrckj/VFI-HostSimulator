<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Isotrx;

/**
 * IsotrxSearch represents the model behind the search form of `app\models\Isotrx`.
 */
class IsotrxSearch extends Isotrx
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isotrx_id', 'isotrx_host_id'], 'integer'],
            [['isotrx_name', 'isotrx_msg_type', 'isotrx_proc_code', 'isotrx_created_by', 'isotrx_created_dt', 'isotrx_updated_by', 'isotrx_updated_dt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Isotrx::find();

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
            'isotrx_id' => $this->isotrx_id,
            'isotrx_host_id' => $this->isotrx_host_id,
            'isotrx_created_dt' => $this->isotrx_created_dt,
            'isotrx_updated_dt' => $this->isotrx_updated_dt,
        ]);

        $query->andFilterWhere(['like', 'isotrx_name', $this->isotrx_name])
            ->andFilterWhere(['like', 'isotrx_msg_type', $this->isotrx_msg_type])
            ->andFilterWhere(['like', 'isotrx_proc_code', $this->isotrx_proc_code])
            ->andFilterWhere(['like', 'isotrx_created_by', $this->isotrx_created_by])
            ->andFilterWhere(['like', 'isotrx_updated_by', $this->isotrx_updated_by]);

        return $dataProvider;
    }
}
