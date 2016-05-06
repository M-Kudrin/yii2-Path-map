
	<html>
	<head>
	<link rel="stylesheet" href="assets\207c5bef\css\bootstrap.css" type="text/css">
	</head>	
	<body>
		<div id="myiframe" width="100%" height="auto">
		<img id ="ima" src="\data\sight2.jpg" width="90%" height="auto" style="align:center" ><br /><br />
			<p>
			<strong>Памятник Ленину</strong><br />
			Скульптура Ленина на площади Революции, установленная 7 ноября 1927. На её же постаменте до революции стоял памятник Александру II
			</p>
			<div width="45%"  >
				<a id="adress-btn" href="#" class="btn btn-info" role="button" onclick="openbox('adress', 'adress-btn'); return false">Адреса</a><br />
				<div id="adress" style="display: none;">
					<p>Адрес: ул. Куйбышева   </p>
				</div>
			</div><br />
			
		</div>
		<script type="text/javascript">
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

