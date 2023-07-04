<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Message</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php

class Message {
    
    /**
     * Check if a user with the given field and value is registered.
     *
     * @param PDO $pdo The database connection.
     * @param string $table The table to search in.
     * @param string $field The field to search in the specified table.
     * @param mixed $value The value to search for in the specified field.
     * @param bool $excludeCurrentUser Whether to exclude the current user (optional).
     * @param string $currentUserId The ID of the current user to exclude (optional).
     * @param string $userField The field in the specified table where the current user is stored (optional).
     * @return bool Returns true if a registered user is found, false otherwise.
     */
    public static function isRegistered(
        PDO $pdo,
        string $table,
        string $field,
        $value,
        bool $excludeCurrentUser = false,
        string $currentUserId = null,
        string $userField = null
    ): bool
    {
        // Define the SQL query to find the registered user
        $findRegister = "SELECT COUNT(*) FROM $table WHERE $field = ?";
        if ($excludeCurrentUser && $currentUserId !== null && $userField !== null) {
            $findRegister .= " AND $userField != ? AND state != 3";
        }

        // Prepare and execute the SQL query
        $stmt = $pdo->prepare($findRegister);
        if ($excludeCurrentUser && $currentUserId !== null) {
            $stmt->execute([$value, $currentUserId]);
        } else {
            $stmt->execute([$value]);
        }

        // Check if a registered user was found
        return $stmt->fetchColumn() > 0;
    }


    /**
     * Shows a success message and redirects to a specified URL.
     *
     * @param string $message The success message to display.
     * @param string $redirectURL The URL to redirect to.
     * @return void
     */
    public static function showSuccessMessage(string $message, string $redirectURL): void {
        // Call the showMessage function with the 'success' type
        self::showMessage('success', $message, $redirectURL);
    }
    
    /**
     * Show an error message and redirect to a specified URL.
     *
     * @param string $message The error message to display.
     * @param string $redirectURL The URL to redirect to after displaying the message.
     * @return void
     */
    public static function showErrorMessage(string $message, string $redirectURL): void {
        // Delegate the task of showing the error message to the showMessage method.
        self::showMessage('error', $message, $redirectURL);
    }
    
    /**
     * Show a warning message and redirect to a specified URL.
     *
     * @param string $message The warning message to display.
     * @param string $redirectURL The URL to redirect to.
     * @return void
     */
    public static function showWarningMessage(string $message, string $redirectURL): void {
        // Call the showMessage function with the 'warning' message type.
        self::showMessage('warning', $message, $redirectURL);
    }

    /**
     * Display a message with an icon, title, and redirect URL.
     *
     * @param string $icon The icon to display in the message.
     * @param string $message The message content.
     * @param string $redirectURL The URL to redirect to after displaying the message.
     * @return void
     */
    private static function showMessage(string $icon, string $message, string $redirectURL): void {
        echo "
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: '$icon',
                    title: '$message',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location = '$redirectURL';
                });
            </script>
        ";
    }
}
?>
</body>

</html>