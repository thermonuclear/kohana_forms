<?php

return [
    'default' => [
        'type' => 'MySQLi',
        'connection' => [
            /**
             * The following options are available for MySQLi:
             *
             * string   hostname    Server hostname, or socket
             * string   database    Database name
             * string   username    Database username
             * string   password    Database password
             * bool     persistent  Use persistent connections?
             * array    ssl         SSL parameters as "key => value" pairs.
             *                      Available keys: client_key_path, client_cert_path, ca_cert_path, ca_dir_path, cipher
             * array    variables   System variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
            'hostname' => 'mysql',
            // 'hostname' => '172.21.0.3',
            'database' => 'app',
            'username' => 'app',
            'password' => 'app',
            'persistent' => false,
            'ssl' => null,
        ],
        /**
         * The following extra options are available for PDO:
         *
         * string   identifier  Set the escaping identifier
         */
        'table_prefix' => '',
        'charset' => 'utf8',
        'caching' => false,
    ],
];
