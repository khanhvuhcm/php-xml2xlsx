<?php

namespace Core\Auth;

class XCSRF
{
    // Constant name value to access 'xcsrf_token' in the $_SESSION
    const XCSRF_TOKEN = "xcsrf_token";

    public static function setNewCSRFToken()
    {
        // Sets new random anti CSRF token.
        $_SESSION[self::XCSRF_TOKEN] = bin2hex(random_bytes(32));
    }

    public static function csrfInput()
    {
        // Returns <input type='hidded'> with value set to the new random anti CSRF token.
        self::setNewCSRFToken();
        return "<input type='hidden' name='" . self::XCSRF_TOKEN . "' value='" . $_SESSION[self::XCSRF_TOKEN] . "'>";
    }

    public static function tokenIsOK($postedToken)
    {
        // Checks if submitted XCSRF token equals the current XCSRF token stored in the $_SESSION
        if ($_SESSION[self::XCSRF_TOKEN] === $postedToken){
            return true;
        }
        return false;
    }
}
