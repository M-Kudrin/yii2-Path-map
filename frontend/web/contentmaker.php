<?php


if (isset($_GET['sightj'])) {
$jsight = $_GET['sightj'];

$id = $jsight["SightId"];
$name = $jsight["Sightname"];
$description = $jsight["descriptions"];
$typeid = $jsight["SightTypeId"];
$adress = $_GET['adress'];
$contact = $_GET['contact'];

$handle = fopen("content.php", "w");

fwrite($handle, "
	<html>
	<head>
	<link rel=\"stylesheet\" href=\"assets\\207c5bef\\css\\bootstrap.css\" type=\"text/css\">
	</head>	
	<body>
		<div id=\"myiframe\" width=\"100%\" height=\"auto\">
		<img id =\"ima\" src=\"\\data\\sight".$id.".jpg\" width=\"90%\" height=\"auto\" style=\"align:center\" ><br /><br />
			<p>
			<strong>".$name."</strong><br />
			".$description."
			</p>
			<div width=\"45%\"  >
				<a id=\"adress-btn\" href=\"#\" class=\"btn btn-info\" role=\"button\" onclick=\"openbox('adress', 'adress-btn'); return false\">Адреса</a><br />
				<div id=\"adress\" style=\"display: none;\">
					<p>Адрес: ".$adress["Street"]."  ".$adress["Number"]." ".$adress["Litera"]."</p>
				</div>
			</div><br />
			");

			if ($contact != '')
			{
				
				fwrite($handle, "
			<div width=\"45%\" >
				<a id=\"contact-btn\" href=\"#\" class=\"btn btn-info\" role=\"button\" onclick=\"openbox('contact', 'contact-btn'); return false\">Контакты</a><br />
				<div id=\"contact\" style=\"display: none;\">
					<p>Телефон: ".$contact["phone"]."</p>
					<p>Сайт: ".$contact["site"]."</p>
					<p>Рабочее время: ".$contact["WorkTime"]."</p>
				</div>
			</div>
			");
			}
			fwrite($handle, "
		</div>
		<script type=\"text/javascript\">
		function openbox(id, btnid){
document.getElementById(btnid).style.display = 'none';

    display = document.getElementById(id).style.display;
    if(display=='none'){
       document.getElementById(id).style.display='inline-block';
    }else{
       document.getElementById(id).style.display='none';
    }
}

</script>

	</body>
	</html>

"); 


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