<?php

/*
 * Funky Cache - Frog CMS caching plugin
 *
 * Copyright (c) 2008 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/funky_cache
 *
 */

$PDO = Record::getConnection();

$table = TABLE_PREFIX . "setting";
$PDO->exec("DELETE FROM $table 
            WHERE name='funky_cache_by_default' 
            LIMIT 1");
$PDO->exec("DELETE FROM $table 
            WHERE name='funky_cache_suffix' 
            LIMIT 1");
$PDO->exec("DELETE FROM $table 
            WHERE name='funky_cache_folder' 
            LIMIT 1");
            
$table = TABLE_PREFIX . "page";
$PDO->exec("ALTER TABLE $table 
            DROP COLUMN 'funky_cache_enabled'");

$table = TABLE_PREFIX . "funky_cache_page";
$PDO->exec("DROP TABLE $table");
