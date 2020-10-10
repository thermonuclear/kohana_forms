<?php


class Auth_Db extends Auth
{

    protected function _login($login, $password, $remember)
    {
        $passwordDb = Model::factory('User')->getPasswordByLogin($login);

        if ($passwordDb AND password_verify($password, $passwordDb[0]['user_password'])) {
            return $this->complete_login($login);
        }

        // Login failed
        return false;
    }

    public function password($login)
    {
        $passwordDb = Model::factory('User')->getPasswordByLogin($login);

        return $passwordDb ? $passwordDb[0]['user_password'] : false;
    }

    public function check_password($password)
    {
        $username = $this->get_user();

        if ($username === false) {
            return false;
        }

        return password_verify($password, $this->password($username));
    }

    /**
     * hash password.
     *
     * @param   string  $str  string to hash
     * @return  string
     */
    public function hash($str)
    {
        return password_hash($str, $this->_config['hash_method']);
    }
}
