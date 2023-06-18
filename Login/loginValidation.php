<?php
    class Login
    {
        /**
         * Logs in a user
         *
         * @param string $docType The type of document of the user
         * @param string $id The id of the user
         * @param string $pass The password of the user
         *
         * @return void
         */
        public function loginUser(string $docType, string $id, string $pass)
        {
            // Start session
            session_start();
            
            // Connect to database
            require_once "../persistence/database/Database.php";
            $db = Database::conectar();

            // Initialize counter
            $cont = 0;

            // Query database for user
            $sql2 = "
                SELECT * FROM user
                JOIN user_has_role
                    ON pk_fk_cod_doc = tdoc_role &&
                        pk_fk_id_user = id_user
                WHERE pk_fk_cod_doc = '$docType'
                    AND id_user='$id'
                    AND pass='$pass'
            ";
            $result = $db->query($sql2);

            // Loop through query result and assign values to variables
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $ttDoc = stripslashes($row["pk_fk_cod_doc"]);
                $idPerson = stripslashes($row["id_user"]);
                $firstName = stripslashes($row["first_name"]);
                $secondName = stripslashes($row["second_name"]);
                $firstLastName = stripslashes($row["surname"]);
                $secondLastName = stripslashes($row["second_surname"]);
                $username = stripslashes($row["user_name"]);
                $photo = stripslashes($row["photo"]);
                $rol = stripslashes($row["pk_fk_role"]);
                $cont ++;
            }

            // If user is not found, display error message and redirect to login page
            if ($cont == 0) {
                print "
                    <script>
                        alert(\"Usuario y/o Password Incorrectas.\");
                        window.location='../index.php';
                    </script>
                ";
            }

            // If user is found, set session variables and query database for user role
            if ($cont != 0) {

                $_SESSION["TIPO_DOC"] = $ttDoc;
                $_SESSION["ID_PERSONA"] = $idPerson;
                $_SESSION["USERNAME"] = $username;
                $_SESSION["PHOTO"] = $photo;
                $_SESSION["NAME"] = $firstName;
                $_SESSION["SNAME"] = $secondName;
                $_SESSION["LASTNAME"] = $firstLastName;
                $_SESSION["SLASTNAME"] = $secondLastName;
                $_SESSION["FK_ROL"] = $rol;

                $sql = "
                    SELECT pk_fk_role
                    FROM user
                    JOIN user_has_role
                        ON id_user = pk_fk_id_user
                    WHERE pk_fk_cod_doc ='$ttDoc' &&
                        id_user='$idPerson'
                ";
                $result = $db->query($sql);

                // Loop through query result and assign role to variable
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $role = stripslashes($row["pk_fk_role"]);
                }

                // If user does not have a role, display error message and redirect to login page
                if ($role === null) {
                    print "
                        <script>
                            alert(\"El usuario NO se encuentra con un rol asignado\");
                            window.location='../index.php';
                        </script>
                    ";
                }

                // Redirect to appropriate page based on user role
                if ($role === 'TEACHER') {
                    $_SESSION['active'] = 1;
                    header('location: ../utilities/index.php?role=t');
                } elseif ($role === 'ADMIN') {
                    $_SESSION['active'] = 1;
                    header('location: ../utilities/index.php?role=e');
                } elseif ($role === 'ATTENDANT') {
                    $_SESSION['active'] = 1;
                    header('location: ../utilities/index.php?role=att');
                }
            }
        }
    }
    
    $new = new Login();
    $new->loginUser($_POST["tipo_doc"], $_POST["id"], $_POST["pass"]);
?>
