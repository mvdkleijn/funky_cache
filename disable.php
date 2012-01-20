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
 
/* Prevent direct access. */
if (!defined("FRAMEWORK_STARTING_MICROTIME")) {
    die("All your base are belong to us!");
}

$PDO = Record::getConnection();

$cache = Record::findAllFrom('FunkyCachePage');
foreach ($cache as $page) {
    $page->delete();
}

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
