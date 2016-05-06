<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sighttype".
 *
 * @property integer $SightTypeId
 * @property string $TypeName
 *
 * @property Sight[] $sights
 */
class Sighttype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sighttype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SightTypeId'], 'required'],
            [['SightTypeId'], 'integer'],
            [['TypeName'], 'string', 'max' => 450],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SightTypeId' => 'Sight Type ID',
            'TypeName' => 'Type Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSights()
    {
        return $this->hasMany(Sight::className(), ['SightTypeId' => 'SightTypeId']);
    }
}
