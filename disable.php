<?php

$PDO = Record::getConnection();
$table = TABLE_PREFIX . "setting";
$PDO->exec("DELETE FROM $table 
            WHERE name='funky_cache_by_default' 
            LIMIT 1");

$table = TABLE_PREFIX . "funky_cache_page";

$PDO->exec("DROP TABLE $table");
