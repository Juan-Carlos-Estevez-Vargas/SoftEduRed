<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="style/index_style.css">
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<div id="titulo">
	<div align="right">
	<?php include "roles.php"; if ($_SESSION['role_index'] === 'e'): ?>
	</div>
		<p id="header">WELCOME ADMIN</p>	
	</div>
	<header>
		<div class="contenedor" id="uno">
			<a href="marco.php" target="mainFrame"><img src="pictures/icon1.png" border="0" class="icon"></a>
			<p class="texto">Home</p>
	  	</div>
		<div class="contenedor" id="dos">
			<a href="cruds.php" target="mainFrame"><img class="icon" src="pictures/icon2.png"></a>
			<p class="texto">Registers</p>
		</div>
		<div class="contenedor" id="tres">
			<img class="icon" src="pictures/icon3.png">
			<p class="texto">Contactenos</p>
		</div>
		<div class="contenedor" id="cuatro">
			<a href="../Login/cerrar_sesion.php" target="_parent"><img class="icon" src="pictures/icon7.png"></a>
			<p class="texto">Cerrar Sesion</p>
		</div>
	</header>
  <?php endif;
 
  if ($_SESSION['role_index'] === 'att'): ?>     
	</div>
		<p id="header">WELCOME ATTENDANT</p>	
	</div>
	<header>
		<div class="contenedor" id="uno">
			<a href="marco.php" target="mainFrame"><img src="pictures/icon1.png" border="0" class="icon"></a>
			<p class="texto">Home</p>
	 	</div>
		<div class="contenedor" id="dos">
			<a href="../no_attendance/stu_asistance.php" target="mainFrame"><img class="icon" src="pictures/icon8.png"></a>
			<p class="texto">Asistence</p>
		</div>
		<div class="contenedor" id="tres">
         <a href="info_user.php" target="mainFrame"><img class="icon" src="pictures/icon6.png"></a>
			<p class="texto">Personal Info</p>
		</div>
		<div class="contenedor" id="cuatro">
			<a href="../Login/cerrar_sesion.php" target="_parent"><img class="icon" src="pictures/icon7.png"></a>
			<p class="texto">Cerrar Sesion</p>
		</div>
	</header>
  <?php endif; if ($_SESSION['role_index'] === 'st'): ?>  

	</div>
		<p id="header">WELCOME STUDENT</p>	
	</div>
	<header>
		<div class="contenedor" id="uno">
			<a href="marco.php" target="mainFrame"><img src="pictures/icon1.png" border="0" class="icon"></a>
			<p class="texto">Home</p>
	    </div>
		<div class="contenedor" id="dos">
			<a href="../no_attendance/stu_asistance.php" target="mainFrame"><img class="icon" src="pictures/icon8.png"></a>
			<p class="texto">My Asistance</p>
		</div>
		<div class="contenedor" id="tres">
         <a href="info_user.php" target="mainFrame"><img class="icon" src="pictures/icon6.png"></a>
			<p class="texto">Personal Info</p>
		</div>
		<div class="contenedor" id="cuatro">
			<a href="../Login/cerrar_sesion.php" target="_parent"><img class="icon" src="pictures/icon7.png"></a>
			<p class="texto">Cerrar Sesion</p>
		</div>
	</header>
	
  <?php endif; if ($_SESSION['role_index'] === 't'): ?>     
	</div>
		<p id="header">WELCOME TEACHER</p>	
	</div>
	<header>		
		<div class="contenedor" id="uno">
			<a href="marco.php" target="mainFrame"><img src="pictures/icon1.png" border="0" class="icon"></a>
			<p class="texto">Home</p>
	    </div>
		<div class="contenedor" id="dos">
			<a href="../no_attendance/formu_view.php" target="mainFrame"><img class="icon" src="pictures/icon8.png"></a>
			<p class="texto">Assistance</p>
		</div>
		<div class="contenedor" id="tres">
         <a href="info_user.php" target="mainFrame"><img class="icon" src="pictures/icon6.png"></a>
			<p class="texto">Personal Info</p>
		</div>
		<div class="contenedor" id="cuatro">
			<a href="../Login/cerrar_sesion.php" target="_parent"><img class="icon" src="pictures/icon7.png"></a>
			<p class="texto">Cerrar Sesion</p>
		</div>
	</header>
  <?php endif; ?>
</body>
</html>
