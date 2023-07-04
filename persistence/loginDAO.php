<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
    class LoginDAO
    {
        /**
         * Retrieves a user from the database based on the username and password
         *
         * @param PDO $db The database connection
         * @param string $username The username of the user
         * @param string $password The password of the user
         *
         * @return array|false Returns the user as an associative array if found, false otherwise
         */
        public function getUser(PDO $db, string $username, string $password)
        {
            $sql = "
                SELECT * FROM user
                WHERE username = :username
                    AND password = :password
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $password]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Retrieves the role of a user from the database
         *
         * @param PDO $db The database connection
         * @param int $userId The ID of the user
         *
         * @return array|false Returns the role as an associative array if found, false otherwise
         */
        public function getUserRole(PDO $db, int $userId)
        {
            $sql = "
                SELECT description FROM role
                JOIN user_has_role
                    ON id_role = role_id
                WHERE user_id = :user_id
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
</body>

</html>