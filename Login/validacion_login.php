    <?php
        class Login {
         public function Login_user($tipo_doc,$id, $pass){
             session_start();
             require_once "../Database/conexion.php";
             $db = database::conectar();
             $cont =0;
             $sql2 = "SELECT * FROM user JOIN user_has_role ON pk_fk_cod_doc = tdoc_role && pk_fk_id_user = id_user  WHERE pk_fk_cod_doc = '$tipo_doc' AND id_user='$id' AND pass='$pass'";
             $result2 = $db->query($sql2);
             
             while ($row2=$result2->fetch(PDO::FETCH_ASSOC)) {
                 $tt_doc=stripslashes($row2["pk_fk_cod_doc"]);
                 $iid_persona=stripslashes($row2["id_user"]);
                 $fname=stripslashes($row2["first_name"]);
                 $sname=stripslashes($row2["second_name"]);
                 $flastname=stripslashes($row2["surname"]);
                 $slastname=stripslashes($row2["second_surname"]);
                 $uusername=stripslashes($row2["user_name"]);
                 $ppassword=stripslashes($row2["pass"]);
                 $ffoto=stripslashes($row2["photo"]);
                 $rrol=stripslashes($row2["pk_fk_role"]);
                 $cont=$cont+1; 
             }
			 
             if($cont==0){
                 print "<script>alert(\"Usuario y/o Password Incorrectas.\");window.location='../index.php';</script>";
             }
             
             if ($cont!=0){
                 
                    $_SESSION["TIPO_DOC"]=$tt_doc;
                    $_SESSION["ID_PERSONA"]=$iid_persona;
                    $_SESSION["USERNAME"]=$uusername;
                    $_SESSION["PHOTO"]=$ffoto;
                    $_SESSION["NAME"]=$fname;
                    $_SESSION["SNAME"]=$sname;
                    $_SESSION["LASTNAME"]=$flastname;
                    $_SESSION["SLASTNAME"]=$slastname;
                    $_SESSION["FK_ROL"]=$rrol;

                    $sql1="SELECT pk_fk_role FROM user JOIN user_has_role ON id_user = pk_fk_id_user WHERE pk_fk_cod_doc ='$tt_doc' && id_user='$iid_persona'";
                    $result1 = $db->query($sql1);
                         
                 while ($row1=$result1->fetch(PDO::FETCH_ASSOC)){
                     $role=stripslashes($row1["pk_fk_role"]);
                 }
                 
                    if ($role === null){       
                        print "<script>alert(\"El Usuario NO Se Encuentra Con Un Rol Asignado\");window.location='../index.php';</script>";
                    }
                 
                    if ($role === 'TEACHER'){
                        $_SESSION['active']=1;
                        header ('location: ../indexs/index.php?role=t');
                    }
                 
                    elseif ($role === 'ADMIN'){
                        $_SESSION['active']=1;
                        header ('location: ../indexs/index.php?role=e');
                    }
                  
                    elseif ($role === 'ATTENDANT'){
                        $_SESSION['active']=1;
                        header ('location: ../indexs/index.php?role=att');
                    }
                  
                    elseif ($role === 'STUDENT'){
                        $_SESSION['active']=1;
                        header ('location: ../indexs/index.php?role=st');
                    }
                    elseif ($role === 'INVITED'){
						session_destroy();
                        print "<script>alert(\"Usuario Su Rol Aún Es Temporal, Por Favor Comuniquese Con El Administrador\");window.location='../index.php';</script>";
                    }

             }
         }
        }
        
        $Nuevo=new Login();
        $Nuevo->Login_user($_POST["tipo_doc"],$_POST["id"],$_POST["pass"]);
    ?>
