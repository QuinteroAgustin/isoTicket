<?php

namespace App\Helpers;

class FunctionHelper {

    /**
     * Vérifie si l'email est valide.
     * FunctionHelper::validateEmail($email)
     * @param string $email
     * @return bool
     */
    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
