<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../assets/css/rol.css">
  <title>Bienvenidos</title>
</head>

<body>
  <?php
        require_once "../persistence/Database/Database.php";
        $db = database::connect();
        session_start();
    ?>
  <div class="select">
    <label>Seleccione:</label>
    <select name="slct" onchange="window.open(this.value, '_parent', '')">
      <option class="rol" selected disabled>Rol:</option>
      <?php
            $sql = "
            SELECT r.description AS role_description,
                uhr.state AS user_has_role_state
            FROM role r
            JOIN user_has_role uhr
                ON uhr.role_id = r.id_role
            WHERE uhr.user_id ='".$_SESSION["ID_USER"]."'
                AND uhr.state = 1
            ";
            $result = $db->query($sql);
        
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $role = stripslashes($row["role_description"]);
                $estate = stripslashes($row["user_has_role_state"]);

                if ($estate === null){
                    print "
                        <script>
                            alert(\"ROL INACTIVO\");
                            window.location='cerrar_session.php';
                        </script>
                    ";
                }
            
                if ($rol === 'ADMIN') {
                    echo "<option value='index.php?role=e'>Administrador</option>";
                }
            
                if ($rol === 'TEACHER') {
                    echo "<option value='index.php?role=t'>Docente</option>";
                }
            
                if ($rol === 'ATTENDANT') {
                    echo "<option value='index.php?role=att'>Acudiente</option>";
                }
            
                if ($rol === 'STUDENT') {
                    echo "<option value='index.php?role=st'>Estudiante</option>";
                }
            }
        ?>
    </select>
  </div>
</body>

</html>