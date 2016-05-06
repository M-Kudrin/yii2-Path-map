<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adress".
 *
 * @property integer $AdressId
 * @property string $Street
 * @property string $Litera
 * @property integer $Number
 *
 * @property Sight[] $sights
 */
class Adress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['AdressId'], 'required'],
            [['AdressId', 'Number'], 'integer'],
            [['Street', 'Litera'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'AdressId' => 'Adress ID',
            'Street' => 'Street',
            'Litera' => 'Litera',
            'Number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSights()
    {
        return $this->hasMany(Sight::className(), ['AdressId' => 'AdressId']);
    }
}
