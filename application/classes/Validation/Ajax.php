<?php


class Validation_Ajax
{
    public function registrationValidate(array $data)
    {
        $existUser = Model::factory('User')->checkExistUser($data);

        return (Validation::factory($data))
            ->rule('login', 'not_empty')
            ->rule('login', function(Validation $array, $field, $value) use ($existUser) {
                    if ($existUser['login']) {
                        $array->error($field, "Логин $value уже используется");
                    }
                }, [':validation', ':field', ':value'])
            ->rule('email', 'email')
            ->rule('email', function(Validation $array, $field, $value) use ($existUser) {
                if ($existUser['email']) {
                    $array->error($field, "email $value уже используется");
                }
            }, [':validation', ':field', ':value'])
            ->rule('password', 'min_length', [':value', '6'])
            ->rule('password', 'alpha_numeric');
    }
}
