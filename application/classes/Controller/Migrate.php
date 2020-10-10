<?php

class Controller_Migrate extends Controller
{
    /**
     * http://new-disc.test/migrate/create
     */
    public function action_create()
    {
        $sql = "CREATE TABLE IF NOT EXISTS sessions (
                session_id VARCHAR(24) NOT NULL,
                last_active INT UNSIGNED NOT NULL,
                contents TEXT NOT NULL,
                PRIMARY KEY (session_id),
                KEY (last_active)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COMMENT='сессии'
        ";
        DB::query(null, $sql)->execute();

        $sql = "CREATE TABLE IF NOT EXISTS users (
                user_id BIGINT UNSIGNED NOT NULL auto_increment,
                user_login VARCHAR(32) NOT NULL,
                user_email VARCHAR(32) NOT NULL,
                user_password VARCHAR(255) NOT NULL,
                user_link VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'ссылка для восстановления пароля',
                PRIMARY KEY (user_id),
                KEY (user_login),
                KEY (user_email),
                KEY (user_link)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COMMENT='пользователи'
        ";
        DB::query(null, $sql)->execute();

        $sql = "CREATE TABLE IF NOT EXISTS words (
                word VARCHAR(255),
                stat INT NOT NULL,
                PRIMARY KEY (word)
            ) ENGINE=InnoDb DEFAULT CHARSET=utf8 COMMENT='статистика использования слов'
        ";
        DB::query(null, $sql)->execute();

        $this->response->body('success');
    }
}
