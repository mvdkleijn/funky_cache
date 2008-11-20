<?php

$PDO = Record::getConnection();
$table = TABLE_PREFIX . "setting";
$PDO->exec("INSERT INTO $table (name, value) 
            VALUES ('funky_cache_by_default', '1')");

$table = TABLE_PREFIX . "funky_cache_page";

$PDO->exec("CREATE TABLE $table (
            id int(11) NOT NULL auto_increment,
            url varchar(255) default NULL,
            created_on datetime default NULL,
            PRIMARY KEY (id),
            UNIQUE (url)
            ) DEFAULT CHARSET=utf8");

            
