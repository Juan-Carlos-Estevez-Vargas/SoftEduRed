<!DOCTYPE HTML>
<HTML>
<HEAD>
    <link rel="stylesheet" type="text/css" href="style/rol.css">
    <META charset="utf-8"/>
    <TITLE>BIENVENIDOS</TITLE>
</HEAD>
    <BODY>
        <?php
            require_once "../Database/conexion.php";
            $db = database::conectar();
            session_start();
        ?>

        <div class="select">
        <label>Seleccione:</label> <select name="slct" onchange="window.open(this.value, '_parent', '')">
            <option class="rol" selected disabled>ROL:</option>
        
        <?php
        $sql = "SELECT * FROM user_has_role WHERE pk_fk_id_user ='".$_SESSION["ID_PERSONA"]."' AND tdoc_role ='".$_SESSION["TIPO_DOC"]."' AND state =1";
        $result=$db->query($sql);
        
        while ($row1=$result->fetch(PDO::FETCH_ASSOC)){
            $rol=stripslashes($row1["pk_fk_role"]);
            $estado=stripslashes($row1["state"]);
            if ($estado === null){
                print "<script>alert(\"ROL INACTIVO\");window.location='cerrar_session.php';</script>";
            }
            
            if ($rol === 'ADMIN'){   
                echo "<option value='index.php?role=e'>ADMINISTRADOR</option>";
            }
            
            if ($rol === 'TEACHER'){       
                echo "<option value='index.php?role=t'>DOCENTE</option>";
            }
            
            if ($rol === 'ATTENDANT'){
                echo "<option value='index.php?role=att'>ACUDIENTE</option>";
            }
            
            if ($rol === 'STUDENT'){
                echo "<option value='index.php?role=st'>ESTUDIANTE</option>";
            }
        } ?>
        
        </select>
       </div>
    </BODY>
</HTML>