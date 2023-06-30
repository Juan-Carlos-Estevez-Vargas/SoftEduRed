<?php

class Message {
    
    /**
     * Check if a user with the given field and value is registered.
     *
     * @param PDO $pdo The database connection.
     * @param string $field The field to search in the user table.
     * @param mixed $value The value to search for in the specified field.
     * @return bool Returns true if a registered user is found, false otherwise.
     */
    public static function isRegistered($pdo, $field, $value): bool
    {
        // Prepare the SQL statement to find a user with the specified field and value
        $findRegister = "SELECT * FROM user WHERE $field = ?";
        
        // Prepare and execute the SQL statement using PDO
        $stmt = $pdo->prepare($findRegister);
        $stmt->execute([$value]);
        
        // Return true if a registered user is found, false otherwise
        return $stmt->rowCount() > 0;
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