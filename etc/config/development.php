<?php

$dbFile = Shiratama_Util::catfile(ROOT, 'etc', 'db', 'development.db');
$config = array(
    'DB' => array(
        'sqlite:' . $dbFile,
        '',
        ''
    ),
);
