<?php
namespace app\views\site;

use Yii;
use app\models\Sight



if (isset($_GET['test'])) {

$id= test.SightId;
$handle = fopen("\content.html", "w");

fwrite($handle, "<html><body><p>".$id."</p></body></html>"); 

fclose($handle);

}







/*if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'test' : test();break;
        case 'blah' : blah();break;
        // ...etc...
    }
}
public function popupHTML($sightjson){
	$jop = json_decode($sightjson, JSON_UNESCAPED_UNICODE);


}
*/
?>