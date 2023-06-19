<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../assets/css/buttons.css">
	<title></title>
</head>
<body>
	<div id="title">
		<div>
			<?php include "roles.php"; if ($_SESSION['role_index'] === 'e'): ?>
		</div>
		<p id="header">Bienvenido Administrador</p>
	</div>
	<header>
		<div class="container" id="one">
			<a href="marco.php" target="mainFrame">
				<img src="../assets/icons/home-icon.png" class="icon" alt="Inicio">
			</a>
			<p class="text">Inicio</p>
	  </div>
		<div class="container" id="two">
			<a href="cruds.php" target="mainFrame">
				<img class="icon" src="../assets/icons/register-icon.png" alt="Registros">
			</a>
			<p class="text">Registros</p>
		</div>
		<div class="container" id="three">
			<img class="icon" src="../assets/icons/google-plus-icon.png" alt="Google Plus">
			<p class="text">Contáctenos</p>
		</div>
		<div class="container" id="four">
			<a href="../Login/cerrar_sesion.php" target="_parent">
				<img class="icon" src="../assets/icons/logout-icon.png" alt="Cerrar Sesión">
			</a>
			<p class="text">Cerrar Sesión</p>
		</div>
	</header>
  <?php endif;
  	if ($_SESSION['role_index'] === 'att'): ?>
	<div>
		<p id="header">Bienvenido Acudiente</p>
	</div>
	<header>
		<div class="container" id="one">
			<a href="marco.php" target="mainFrame">
				<img src="../assets/icons/home-icon.png" class="icon" alt="Inicio">
			</a>
			<p class="text">Inicio</p>
	 	</div>
		<div class="container" id="two">
			<a href="../no_attendance/stu_asistance.php" target="mainFrame">
				<img class="icon" src="../assets/icons/assistance-icon.png" alt="Asistencias">
			</a>
			<p class="text">Asistencias</p>
		</div>
		<div class="container" id="three">
      <a href="info_user.php" target="mainFrame">
				<img class="icon" src="../assets/icons/personal-info-icon.png" alt="Información Personal">
			</a>
			<p class="text">Información Personal</p>
		</div>
		<div class="container" id="four">
			<a href="../login/cerrar_sesion.php" target="_parent">
				<img class="icon" src="../assets/icons/logout-icon.png" alt="Cerrar Sesión">
			</a>
			<p class="text">Cerrar Sesión</p>
		</div>
	</header>
  <?php endif; if ($_SESSION['role_index'] === 'st'): ?>
	<div>
		<p id="header">Bienvenido Estudiante</p>
	</div>
	<header>
		<div class="container" id="one">
			<a href="marco.php" target="mainFrame">
				<img src="../assets/icons/home-icon.png" class="icon" alt="Inicio">
			</a>
			<p class="text">Inicio</p>
	    </div>
		<div class="container" id="two">
			<a href="../no_attendance/stu_asistance.php" target="mainFrame">
				<img class="icon" src="../assets/icons/assistance-icon.png" alt="Asistencias">
			</a>
			<p class="text">Mis Asistencias</p>
		</div>
		<div class="container" id="three">
      <a href="info_user.php" target="mainFrame">
				<img class="icon" src="../assets/icons/personal-info-icon.png" alt="Información Personal">
			</a>
			<p class="text">Información Personal</p>
		</div>
		<div class="container" id="four">
			<a href="../Login/cerrar_sesion.php" target="_parent">
				<img class="icon" src="../assets/icons/logout-icon.png" alt="Cerrar Sesión">
			</a>
			<p class="text">Cerrar Sesión</p>
		</div>
	</header>
  <?php endif; if ($_SESSION['role_index'] === 't'): ?>
	<div>
		<p id="header">Bienvenido Profesor</p>
	</div>
	<header>
		<div class="container" id="one">
			<a href="marco.php" target="mainFrame">
				<img src="../assets/icons/home-icon.png" class="icon" alt="Inicio">
			</a>
			<p class="text">Inicio</p>
	    </div>
		<div class="container" id="two">
			<a href="../no_attendance/formu_view.php" target="mainFrame">
				<img class="icon" src="../assets/icons/assistance-icon.png" alt="Asistencias">
			</a>
			<p class="text">Asistencias</p>
		</div>
		<div class="container" id="three">
      <a href="info_user.php" target="mainFrame">
				<img class="icon" src="../assets/icons/personal-info-icon.png" alt="Información Personal">
			</a>
			<p class="text">Información Personal</p>
		</div>
		<div class="container" id="four">
			<a href="../Login/cerrar_sesion.php" target="_parent">
				<img class="icon" src="../assets/icons/logout-icon.png" alt="Cerrar Sesión">
			</a>
			<p class="text">Cerrar Sesión</p>
		</div>
	</header>
  <?php endif; ?>
</body>
</html>
