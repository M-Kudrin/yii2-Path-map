<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sight".
 *
 * @property integer $SightId
 * @property string $Sightname
 * @property string $descriptions
 * @property integer $SightTypeId
 * @property integer $AdressId
 * @property integer $ContactId
 * @property double $SightX
 * @property double $SightY
 *
 * @property Sighttype $sightType
 * @property Adress $adress
 * @property Contact $contact
 */
class Sight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
        public function jsonoutput()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Sight::find()->all();
        return $model;
    }

    public static function tableName()
    {
        return 'sight';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SightId', 'Sightname', 'SightX', 'SightY'], 'required'],
            [['SightId', 'SightTypeId', 'AdressId', 'ContactId'], 'integer'],
            [['descriptions'], 'string'],
            [['SightX', 'SightY'], 'number'],
            [['Sightname'], 'string', 'max' => 450],
            [['SightTypeId'], 'exist', 'skipOnError' => true, 'targetClass' => Sighttype::className(), 'targetAttribute' => ['SightTypeId' => 'SightTypeId']],
            [['AdressId'], 'exist', 'skipOnError' => true, 'targetClass' => Adress::className(), 'targetAttribute' => ['AdressId' => 'AdressId']],
            [['ContactId'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['ContactId' => 'ContactId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SightId' => 'Sight ID',
            'Sightname' => 'Sightname',
            'descriptions' => 'Descriptions',
            'SightTypeId' => 'Sight Type ID',
            'AdressId' => 'Adress ID',
            'ContactId' => 'Contact ID',
            'SightX' => 'Sight X',
            'SightY' => 'Sight Y',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSightType()
    {
        return $this->hasOne(Sighttype::className(), ['SightTypeId' => 'SightTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdress()
    {
        return $this->hasOne(Adress::className(), ['AdressId' => 'AdressId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['ContactId' => 'ContactId']);
    }
}
