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
                    SELECT * FROM user_has_role
                    WHERE pk_fk_id_user ='".$_SESSION["ID_PERSONA"]."'
                        AND tdoc_role ='".$_SESSION["TIPO_DOC"]."'
                        AND state = 1
                ";
                $result = $db->query($sql);
            
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $rol = stripslashes($row["pk_fk_role"]);
                    $estate = stripslashes($row["state"]);

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