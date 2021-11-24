<?php  
    class Recu_pass{
        public function recuperar($pass, $pass_conf){
            session_start();
            require_once "../Database/conexion.php";
            $db = database::conectar();
            $sql2 = "SELECT * FROM user WHERE id_user = '".$_SESSION['id']."' AND pk_fk_cod_doc = '".$_SESSION['tdoc']."'";
            $result2 = $db->query($sql2);
            while ($row1=$result2->fetch(PDO::FETCH_ASSOC)){
                $id_user=stripslashes($row1["id"]);
            }
                
            if ($pass === $pass_conf){
                $sql1 = "UPDATE user SET pass = '$pass' WHERE pk_fk_cod_doc = '".$_SESSION["tdoc"]."' AND id_user = '".$_SESSION['id']."'";
                $db->query($sql1);
                session_destroy();
                header ("location: ../index.php");
            } 
        
            if($pass != $pass_conf){
                header ("location: formulario_new_contrasena.php");
            }
        }
    }
    $Nuevo = new Recu_pass();
    $Nuevo->recuperar($_POST['pass'],$_POST['pass_conf']);
?>  