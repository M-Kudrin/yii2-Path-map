<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sight;

/**
 * SightSearch represents the model behind the search form about `app\models\Sight`.
 */
class SightSearch extends Sight
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SightId', 'SightTypeId', 'AdressId', 'ContactId'], 'integer'],
            [['Sightname', 'descriptions'], 'safe'],
            [['SightX', 'SightY'], 'number'],
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
        $query = Sight::find();

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
            'SightId' => $this->SightId,
            'SightTypeId' => $this->SightTypeId,
            'AdressId' => $this->AdressId,
            'ContactId' => $this->ContactId,
            'SightX' => $this->SightX,
            'SightY' => $this->SightY,
        ]);

        $query->andFilterWhere(['like', 'Sightname', $this->Sightname])
            ->andFilterWhere(['like', 'descriptions', $this->descriptions]);

        return $dataProvider;
    }
}
