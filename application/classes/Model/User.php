<?php


class Model_User extends Model_Database
{
    public function checkExistUser(array $data)
    {
        $sql = "SELECT user_login, user_email from users where (user_login = :login OR user_email = :email)";
        $query = DB::query(Database::SELECT, $sql);
        $query->parameters(
            [
                ':login' => $data['login'],
                ':email' => $data['email'],
            ]
        );

        $users = $query->execute()->as_array();
        $result = ['login' => false, 'email' => false];
        foreach ($users as $k => $v) {
            if ($v['user_login'] === $data['login']) {
                $result['login'] = true;
            }
            if ($v['user_email'] === $data['email']) {
                $result['email'] = true;
            }
        }

        return $result;
    }

    public function registerUser(array $data)
    {
        $sql = "INSERT INTO users (user_login, user_email, user_password) VALUES (:login, :email, :password)";
        $query = DB::query(Database::INSERT, $sql);
        $query->parameters(
            [
                ':login' => $data['login'],
                ':email' => $data['email'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ]
        );
        $query->execute();
    }

    public function getPasswordByLogin(string $login)
    {
        $sql = "SELECT user_password from users where user_login = :login";
        $query = DB::query(Database::SELECT, $sql);
        $query->parameters([':login' => $login]);

        return $query->execute()->as_array();
    }

    public function getEmailByLogin(string $login)
    {
        $sql = "SELECT user_email from users where user_login = :login";
        $query = DB::query(Database::SELECT, $sql);
        $query->parameters([':login' => $login]);

        $res = $query->execute()->as_array();

        return $res ? $res[0]['user_email'] : '';
    }

    public function setVerifyLink(string $link, string $login)
    {
        $sql = "UPDATE users SET user_link=:link WHERE user_login=:login";
        $query = DB::query(Database::UPDATE, $sql);
        $query->parameters(
            [
                ':login' => $login,
                ':link' => $link,
            ]
        );
        $query->execute();
    }

    public function setNewPassword(string $pass, string $link)
    {
        $sql = "UPDATE users SET user_password=:pass, user_link='' WHERE user_link=:link";
        $query = DB::query(Database::UPDATE, $sql);
        $query->parameters(
            [
                ':pass' => $pass,
                ':link' => $link
            ]
        );

        return $query->execute();
    }
}
