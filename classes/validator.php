<?php

class Validator
{

    function verifyName($name)
    {
        $name = trim($name);

        if (strlen($name) < 2) {
            return 'First name or last name cannot be less than 2 characters!';
        }

        return true;
    }

    function verifyUsername($username)
    {
        if ($this->verifyName($username) !== true) {
            return 'Username Invalid!';
        }

        $user = new User();

        if ($user->doesUsernameExist($username)) {
            return 'Username already exists';
        }
        return true;
    }

    function verifyEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid Email!';
        }

        $user = new User();
        if ($user->getUserFromEmail($email)) {
            return 'Email already exists!';
        }

        return true;
    }

    function verifyPassword($password)
    {
        if (strlen($password) < 6) {
            return 'Password cannot be less than 6 characters!';
        }
        return true;
    }

    function verifyPasswordUpdate($current_password, $new_password, $retry_password)
    {

        if ($new_password !== $retry_password) {
            return 'New password and confirmation password do not match!';
        }

        if (strlen($new_password) < 6) {
            return 'Password cannot be less than 6 characters!';
        }

        $user = User::current();
        if (!$user->verifyUserPassword($current_password)) {
            return 'Current password does not match!';
        }

        return true;
    }
}
