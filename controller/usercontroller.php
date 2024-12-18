<?php
/**
 * This page is for the operations of the user table.
 * The class `Users` contains variables `$conn` for DB connection and `$table_name` for choosing the table in the database.
 * `config.php` is included for database connection.
 */

include_once 'model/config.php';

class Users {
    private $conn;
    public $table_name;
    public $reset_pass_table;

    /**
     * The __construct() function initializes the database connection.
     */
    public function __construct() {
        global $conn; // Use the global $conn from config.php
        $this->conn = $conn;
        $this->table_name = 'users';
        $this->reset_pass_table = 'password_reset';
    }

    /**
     * The validateUser() function is for login purposes.
     * $_SESSION['username'] and $_SESSION['role'] are stored for future use.
     * When the conditions are verified, it redirects to home.php.
     */
    public function validateUser($post) {
        // Securely fetch inputs
        $email = $this->conn->real_escape_string($post['email']);
        $userpassword = $post['password'];

        // Prepare and execute the query
        $sql = "SELECT * FROM " . $this->table_name . " WHERE e_mail = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user is found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row['password'];

            // Verify the password
            if (password_verify($userpassword, $hash)) {
                session_start(); // Start the session
                $_SESSION['username'] = $row['name'];
                $_SESSION['role'] = $row['role'];

                // Redirect to the welcome page
                header('Location: welcome.php');
                exit();
            } else {
                return "Invalid password!";
            }
        } else {
            return "Invalid Email ID or password!";
        }
    }
}
