<?php

////////////////// CONEXION A LA BASE DE DATOS ////////////////////////////////////

$host="localhost";
$usuario="root";
$contraseña="";
$base="prueba";

$conexion= new mysqli($host, $usuario, $contraseña, $base);
if ($conexion -> connect_errno)
{
	die("Fallo la conexion:(".$conexion -> mysqli_connect_errno().")".$conexion-> mysqli_connect_error());
}
////////////////// VARIABLES DE CONSULTA////////////////////////////////////

$where="";
$codigo=$_POST['idestudiante'];
$per=$_POST="período";
//$limit=$_POST['xregistros'];

////////////////////// BOTON BUSCAR //////////////////////////////////////

if (isset($_POST['buscar']))
{


	if (empty($_POST['período']))
	{
		$where="where período like '".$codigo."%'";
	}

	else if (empty($_POST['idestudiante']))
	{
		$where="where idestudiante='".$per."'";
	}

	else
	{
		$where="where idestudiante like '".$codigo."%' and período='".$per."'";
	}
}
/////////////////////// CONSULTA A LA BASE DE DATOS ////////////////////////

$consultanotas= "SELECT notas.idnotas, notas.idasignatura, asignaturas.nombreasignatura, notas.actividad, notas.evidencia, notas.período, estudiantes.nombreest, detallenotas.idestudiante, detallenotas.nota, estudiantes.grado, notas.ptosposibles, detallenotas.valoración, detallenotas.aprobado
FROM estudiantes INNER JOIN ((asignaturas INNER JOIN notas ON asignaturas.idasignatura = notas.idasignatura) INNER JOIN detallenotas ON notas.idnotas = detallenotas.idregistronotas) ON estudiantes.codigoest = detallenotas.idestudiante  where idestudiante = 244 order by nombreasignatura";
$resultado = mysqli_query($conexion, $consultanotas);
$periodos = mysqli_query($conexion, $consultanotas);
$encab = mysqli_query($conexion, $consultanotas);
?>
<html lang="es">

	<head>
		<title>Consulta de notas</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

		<link href="css/estilos.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	</head>
	<body>
		<header>
			<div class="alert alert-info">
			<h2>Consulta de Calificaciones</h2>
			</div>
		</header>
		<section name=sec1>
		<form method="post">
				<input type="text" placeholder="Código..." name="idestudiante"/>
				<select name="per_sel">
					<option value="">Período</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4"></option>
				</select>

				
				<button name="buscar" type="submit">Consultar</button>
			</form>

		<table name= "tb_not" class="table1" width="50%" border="1" margin= 10%>
				<tr>
				<th><b><center>Código</center></b></th>
				<th><b><center>Nombre Estudiante</center></b></th>
				<th><b><center>Período</center></b></th>
				</tr>

				<?php

                while ($consulta = $encab->fetch_array(MYSQLI_BOTH))
				{
					echo'<tr>
						 <td>'.$consulta['idestudiante'].'</td>
						 <td>'.$consulta['nombreest'].'</td>
						 <td>'.$consulta['período'].'</td>
                         </tr>';
				}
				?>
			</table>
		</section>
		<section name=sec1>
			


			<table id=tb_de_not name= "tb_deta_not" class="table2" width="100%" border="1">
				<tr>
				<th><b><center>Asignatura</center></b></th>
				<th><b><center>Actividad</center></b></th>
				<th><b><center>Evidencia</center></b></th>
				<th><b><center>Nota</center></b></th>
				<th><b><center>Aprobado</center></b></th>
				<th><b><center>PtosPosibles</center></b></th>
				<th><b><center>Valoración</center></b></th>
				</tr>

				<?php

                while ($consulta = $resultado->fetch_array(MYSQLI_BOTH))
				{
					echo'<tr>
						 
						<td>'.$consulta['nombreasignatura'].'</td>
						<td>'.$consulta['actividad'].'</td>
						 <td>'.$consulta['evidencia'].'</td>
						 <td>'.$consulta['nota'].'</td>
                         <td>'.$consulta['aprobado'].'</td>
                         <td>'.$consulta['ptosposibles'].'</td>
                         <td>'.$consulta['valoración'].'</td>
						 </tr>';
				}
				?>
			</table>

			<?
				echo $mensaje;
			?>
		</section>
	</body>
</html>


