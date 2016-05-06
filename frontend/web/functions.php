<?php
namespace frontend\web;

use Yii;
use app\models\Sight;
use app\models\SightSearch;
use yii\web\Controller;

Class Functions{

	public function getsightsoftype(){

		if(isset($_POST['typeid']))
			{
			    $typeid = $_POST['typeid'];

			    $model = Sight::find()->asArray()->where(['SightTypeId' => $typeid])->all(); 
		
				return json_encode($model, JSON_UNESCAPED_UNICODE);
			}

		
	}


}


?>