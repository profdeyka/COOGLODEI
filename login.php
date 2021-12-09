
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Comprobar datos</title> 

</head>
<body>


<?php  
	
	$user = 'root';
	$pass = '';
	$host = 'localhost';
	$database = 'cooglodei';
	$res = null;
	
	$link= mysqli_connect($host,$user,$pass,$database);
	if (!$link) {
		echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}

	
	$sql = "SELECT ID_ROL FROM Cooglodei.persona WHERE usuario='".$_POST['usuario']."' AND CONTRASENA='".$_POST['pas']."'";
	$consult = mysqli_query($link, $sql);
	
    while ($row = mysqli_fetch_array($consult))
    {
        $res = $row["ID_ROL"];
               
    }
	

	if($res == null){
		echo "NO ESTA REGISTRADO";
	}
	else{
		if($res == 1){
			header ("Location: principalA.html");
		}
		else{
			if($res == 2){
				header ("Location: principalC.html");
			}
			else{
				if($res == 3){
					header ("Location: principalP.html");
				}
			}
		}
	}
		
	mysqli_close($link);
?>


</body>
</html>