<?php

$PDO = Record::getConnection();
$table = TABLE_PREFIX . "setting";
$PDO->exec("DELETE FROM $table 
            WHERE name='funky_cache_by_default' 
            LIMIT 1");

$PDO->exec("DROP TABLE funky_cache_page");