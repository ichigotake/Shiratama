<?php

$dbFile = Shiratama_Util::catfile(ROOT, 'db', 'development.db');
$config = array(
    'DB' => array(
        'sqlite:' . $dbFile,
        '',
        ''
    ),
);
