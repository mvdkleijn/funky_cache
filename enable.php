<?php

/*
 * Funky Cache plugin for Wolf CMS. <http://www.wolfcms.org>
 * 
 * Copyright (C) 2012 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * This file is part of the Funky Cache plugin for Wolf CMS. It is licensed
 * under the MIT license.
 * 
 * For details, see:  http://www.opensource.org/licenses/mit-license.php
 */
 
/* Security measure */
if (!defined('IN_CMS')) {
    exit();
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

$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

if ("mysql" == $driver) {
    $PDO->exec("CREATE TABLE $table (
                id int(11) NOT NULL auto_increment,
                url varchar(255) default NULL,
                created_on datetime default NULL,
                PRIMARY KEY (id),
                UNIQUE (url)
                ) DEFAULT CHARSET=utf8");    
}

if ("sqlite" == $driver) {
    $PDO->exec("CREATE TABLE $table (
                id INTEGER NOT NULL PRIMARY KEY,
                url varchar(255) default NULL,
                created_on datetime default NULL,
                UNIQUE (url)
                )");    
}


            
