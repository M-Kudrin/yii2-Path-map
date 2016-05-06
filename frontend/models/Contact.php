<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $ContactId
 * @property string $phone
 * @property string $site
 * @property string $WorkTime
 *
 * @property Sight[] $sights
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ContactId'], 'required'],
            [['ContactId'], 'integer'],
            [['phone', 'site', 'WorkTime'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ContactId' => 'Contact ID',
            'phone' => 'Phone',
            'site' => 'Site',
            'WorkTime' => 'Work Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSights()
    {
        return $this->hasMany(Sight::className(), ['ContactId' => 'ContactId']);
    }
}
