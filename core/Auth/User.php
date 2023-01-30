<?php


namespace Core\Auth;

use Core\Database\DB;
use Core\Auth\SessionVars;


class User
{
    // Any errors that arize are stored here
    public static string $error = "";

    public static function genUID($length = 32)
    {
        // Generates a random string ID.
        return substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(32))), 0, $length);
    }

    public static function emailValid($email)
    {
        // Verifies that the $email is in the 'email@email.com' format,
        // and that its length is less than 100.
        if (
            strlen($email) < 100 &&
            filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            return true;
        }
        return false;
    }

    public static function usernameValid($username) {
        // Verifies that the $username contains only letters from A to Z, numbers, and underscores
        // AND that the length is less than 100.
        if (
            preg_match("/^[a-zA-Z0-9_]+$/", $username) &&
            strlen($username) < 100
        ) {
            return true;
        }

        return false;
    }

    public static function passwordValid($password)
    {
        // Verifies that the $password length is greater than 8.
        if (strlen($password) >= 8) return true;
        return false;
    }

    public static function passwordMatchesUserInfo($password, $userRow)
    {
        // Verifies that the provided $password matches the password in the user's data row.
        if (password_verify($password, $userRow["hashed_password"])) {
            return true;
        }

        return false;
    }

    private static function getUserRow($identifier)
    {
        // Gets the user's data row from the DB based on the $identifier.
        return DB::query(
            "SELECT * FROM users WHERE email = (:identifier) OR username = (:identifier) OR uuid = (:identifier)",
            ["identifier" => $identifier]
        );

    }

    public static function login($identifier, $password)
    {
        /**
         * Log user in with provided $identifier (username or email) and password,
         * then start a new session with the $_SESSION['username']
         */


        // Get the user information from DB, if any exists. If it doesn't exist
        // then there is no user with this $indentifier (username or password)
        $userRow = self::getUserRow($identifier);

        // Verify login info
        if (!$userRow || !self::passwordMatchesUserInfo($password, $userRow)) {
            // If true, either user does not exist, OR the password or username was wrong,
            // so set the error and return.
            self::$error = "Those credentials don't match our records.";
            return;
        }


        // Login was successful, create a new session for the user.
        session_start();
        session_regenerate_id(true);
        $_SESSION[SessionVars::UUID] = $userRow["uuid"];
        $_SESSION[SessionVars::USERNAME] = $userRow["username"];
    }

    public static function logout()
    {
        // Thanks php.net: https://www.php.net/manual/en/function.session-destroy.php

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }



    public static function create($username, $email, $password)
    {
        $existingUser = self::getUserRow($email);
        if ($existingUser) {
            self::$error = "User already exists.";
            return;
        }

        DB::query(
            "INSERT INTO users (username, email, hashed_password, uuid)
            VALUES (:username, :email, :hashed_password, :uuid);",
            [
                "username" => $username,
                "email" => $email,
                "hashed_password" => password_hash($password, PASSWORD_BCRYPT, ["rounds" => 10]),
                "uuid" => self::genUID()
            ]
        );

        echo "<p>User created</p>";
    }

    public static function isAuthenticated() {
        /** Checks to see if user is authenticated (if authenticated session started) */
        if (isset($_SESSION[SessionVars::USERNAME])) return true;
        return false;
    }
}