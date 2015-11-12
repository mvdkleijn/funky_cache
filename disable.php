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

$cache = Record::findAllFrom('FunkyCachePage');
foreach ($cache as $page) {
    $page->delete();
}

Plugin::deleteAllSettings('funky_cache');

$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

$table = TABLE_PREFIX . "page";

if (("mysql" == $driver) || ("sqlite" == $driver)) {
    $PDO->exec("ALTER TABLE $table
                DROP COLUMN 'funky_cache_enabled'");
}

if ("pgsql" == $driver)) {
    $PDO->exec("ALTER TABLE $table
                DROP COLUMN funky_cache_enabled");
}

$table = TABLE_PREFIX . "funky_cache_page";
$PDO->exec("DROP TABLE $table");
