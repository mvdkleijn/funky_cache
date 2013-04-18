<?php

    /**
     * Language file for plugin funky_cache
     *
     * @package Plugins
     * @subpackage funky_cache
     *
     * @author @frontenderch
     * @version Wolf 0.7.7
     */

    return array(
        // index.php
        'Cache' => 'Cache',
        'Should cache' => 'Should cache',

        // views/index.php
        'Funky Cache' => 'Funky Cache',
        'Cached pages' => 'Cached pages',
        'Clear all' => 'Clear all',

        // views/documentation.php
        'Funky Cache - Example rewrite rules' => 'Funky Cache - Example rewrite rules',
        'Introduction' => 'Introduction',
        'The Funky Cache plugin works by using mod_rewrite or equivalent rewrite functionality. Below you will find generated examples for the most used HTTP servers.' => 'The Funky Cache plugin works by using mod_rewrite or equivalent rewrite functionality. Below you will find generated examples for the most used HTTP servers.',
        'Please be aware the author of this plugin cannot guarantee the accuracy of these examples and does not know all rewrite systems.' => 'Please be aware the author of this plugin cannot guarantee the accuracy of these examples and does not know all rewrite systems.',
        'Always check the plugin settings after enabling it!' => 'Always check the plugin settings after enabling it!',
        'If you have translated the rewrite rules to another platform, please let the maintainer of this plugin know.' => 'If you have translated the rewrite rules to another platform, please let the maintainer of this plugin know.',

        // views/settings.php
        'Funky Cache Plugin' => 'Funky Cache Plugin',
        'Cache settings' => 'Cache settings',
        'Cache by default' => 'Cache by default',
        'Yes' => 'Yes',
        'No' => 'No',
        'Choose yes if you want your pages to be cached by default. Otherwise you must set caching for each page manually.' => 'Choose yes if you want your pages to be cached by default. Otherwise you must set caching for each page manually.',
        'Cache file suffix' => 'Cache file suffix',
        'Suffix for cache files written to disk. If you use other than .html you also need to update your mod_rewrite rules.' => 'Suffix for cache files written to disk. If you use other than .html you also need to update your mod_rewrite rules.',
        'Cache folder' => 'Cache folder',
        'Folder where static cache files are written. Relative to document root. When you change this you also need to update your mod_rewrite rules.' => 'Folder where static cache files are written. Relative to document root. When you change this you also need to update your mod_rewrite rules.',
        'Save' => 'Save',

        // views/sidebar.php
        'Example rewrite rules' => 'Example rewrite rules',
        'Settings' => 'Settings',
        'About Funky Cache' => 'About Funky Cache',
        'The Funky Cache plugin allows you to cache pages on the filesystem. It works by using mod_rewrite or equivalent rewrite functionality.' => 'The Funky Cache plugin allows you to cache pages on the filesystem. It works by using mod_rewrite or equivalent rewrite functionality.',
        'Homepage' => 'Homepage',

        // FunkyCacheController.php
        'Page was deleted from cache.' => 'Page was deleted from cache.',
        'The cached page could not be deleted. Try manually from the commandline.' => 'The cached page could not be deleted. Try manually from the commandline.',
        'Cache cleared successfully.' => 'Cache cleared successfully.',
        'One or more cached pages could not be deleted. Try manually from the commandline.' => 'One or more cached pages could not be deleted. Try manually from the commandline.',
        'The cache settings have been updated.' => 'The cache settings have been updated.',
        'The cache settings could not be updated due to an error.' => 'The cache settings could not be updated due to an error.',

    );