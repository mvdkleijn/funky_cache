<?php

/*
 * Funky Cache - Frog CMS caching plugin
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/funky_cache
 *
 */
 
/* Prevent direct access. */
if (!defined("FRAMEWORK_STARTING_MICROTIME")) {
    die("All your base are belong to us!");
}
 
$PDO = Record::getConnection();

$table = TABLE_PREFIX . "setting";
$PDO->exec("INSERT INTO $table (name, value) 
            VALUES ('funky_cache_by_default', '1')");

/* Use system suffix for cache files.        */
/* If no suffix is set use .html by default. */
$suffix = trim(URL_SUFFIX) ? URL_SUFFIX : ".html";
$PDO->exec("INSERT INTO $table (name, value) 
            VALUES ('funky_cache_suffix', '$suffix')");

/* By default write static files to document root. */
$PDO->exec("INSERT INTO $table (name, value) 
            VALUES ('funky_cache_folder', '/cache/')");
                    
$table = TABLE_PREFIX . "page";
$PDO->exec("ALTER TABLE $table
            ADD funky_cache_enabled tinyint(1) 
            NOT NULL default 1");

$table = TABLE_PREFIX . "funky_cache_page";

$PDO->exec("CREATE TABLE $table (
            id int(11) NOT NULL auto_increment,
            url varchar(255) default NULL,
            created_on datetime default NULL,
            PRIMARY KEY (id),
            UNIQUE (url)
            ) DEFAULT CHARSET=utf8");

            
