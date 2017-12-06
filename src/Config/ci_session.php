<?php

return [
    'sess_cookie_name' => 'ci_session',
    'sess_table_name'  => 'ci_sessions',
    'sess_expiration'  => '7200',
	'db_connection'    => 'mysql',
    'encrypt_cookie'   => true,
    'encryption_key'   => 'my53cr3tK3y',
    'use_mcrypt'       => true
];
