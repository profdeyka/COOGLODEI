<?php
require_once("dompdf/dompdf_config.inc.php");
	$user = 'root';
	$pass = '';
	$host = 'localhost';
	$database = 'cooglodei';
	$res = null;
	
	$conexion= mysqli_connect($host,$user,$pass,$database) or die ("No se ha podido conectar");
	

$codigoHTML='


<html lang="es">
<head>
    <title> ReportePDF
    </title>
</head>

<body oncontextmenu="return false">

        <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3"><center>
                    REPORTE EJEMPLO PDF
                    </center>
                </td>
            </tr>
            <tr bgcolor="red">
                <td><strong>ID</strong></td>
                <td><strong>Usuario</strong></td>
                <td><strong>Contrasena</strong></td>
				<td><strong>Nombre</strong></td>
				<td><strong>Apellido</strong></td>
				<td><strong>Fecha de Nacimiento</strong></td>
				<td><strong>Celular</strong></td>
            </tr>';

                $consul = "SELECT * FROM PERSONA WHERE ID_ROL = 2";

                $sql=mysqli_query($conexion, $consul);
                while($res=mysqli_fetch_array($sql)){
                    $codigoHTML.='
                        <tr>
                            <td>'.$res['id_persona'].'</td>
                            <td>'.$res['usuario'].'</td>
                            <td>'.$res['contrasena'].'</td>
							<td>'.$res['nombre'].'</td>
							<td>'.$res['apellido'].'</td>
							<td>'.$res['fecha_nacimiento'].'</td>
							<td>'.$res['movil'].'</td>
                        </tr>';
                }
            $codigoHTML.='
        </table>
</body> </html>';

 $codigoHTML=utf8_encode($codigoHTML);
 $dompdf=new DOMPDF();
 $dompdf->load_html($codigoHTML);
 ini_set("memory_limit","128M");
 $dompdf->render();
 $dompdf->stream("Reporte_user.pdf");     ?>
