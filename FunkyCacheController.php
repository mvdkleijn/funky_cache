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

/**
 * The Funky Cache plugin provides caching functionality for Wolf CMS.
 *
 * @package wolf
 * @subpackage plugin.funky_cache
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @author Mika Tuupola
 * @copyright Martijn van der Kleijn, 2012
 * @copyright Mika Tuupola, 2008-2009
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class FunkyCacheController extends PluginController {


    function __construct() {
        AuthUser::load();
        if (!(AuthUser::isLoggedIn())) {
            redirect(get_url('login'));
        }

        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/funky_cache/views/sidebar'));
    }


    function index() {
        $this->display('funky_cache/views/index', array(
            'cached_page' => FunkyCachePage::findAllFrom('FunkyCachePage', '1=1 ORDER BY created_on ASC')
        ));
    }


    function documentation() {
        $this->display('funky_cache/views/documentation');
    }


    function delete($id) {
        $cached_page = FunkyCachePage::findByIdFrom('FunkyCachePage', $id);
        if ($cached_page->delete()) {
            Flash::set('success', 'Page deleted from cache.');
        }
        else {
            Flash::set('error', 'Could not delete cached page. Try manually from commandline.');
        }
        redirect(get_url('plugin/funky_cache/'));
    }


    function clear() {

        // We need to delete them one by one to make sure the filesystem is cleaned too.
        $pages = Record::findAllFrom('FunkyCachePage');
        foreach ($pages as $page) {
            $page->delete();
        }
        Flash::set('success', 'Should have cleared cache.');
        $message = sprintf('Cache was cleared by :username.');
        Observer::notify('log_event', $message, 'funky_cache', 5);
        redirect(get_url('plugin/funky_cache/'));
    }


    function settings() {
        $this->display('funky_cache/views/settings', array(
            'funky_cache_by_default' => Setting::get('funky_cache_by_default'),
            'funky_cache_suffix' => Setting::get('funky_cache_suffix'),
            'funky_cache_folder' => Setting::get('funky_cache_folder')
        ));
    }


    function save() {
        error_reporting(E_ALL);

        /* Setting::saveFromData() does not handle any errors so lets save manually. */
        $pdo = Record::getConnection();
        $table = TABLE_PREFIX.'setting';

        $funky_cache_by_default = $pdo->quote($_POST['funky_cache_by_default']);
        $funky_cache_suffix = $pdo->quote($_POST['funky_cache_suffix']);
        $funky_cache_folder = $pdo->quote($_POST['funky_cache_folder']);

        $query = "UPDATE $table 
                  SET value  = $funky_cache_suffix
                  WHERE name = 'funky_cache_suffix'";
        $success_1 = $pdo->exec($query) !== false;

        $query = "UPDATE $table 
                  SET value  = $funky_cache_by_default 
                  WHERE name = 'funky_cache_by_default'";
        $success_2 = $pdo->exec($query) !== false;

        $query = "UPDATE $table 
                  SET value  = $funky_cache_folder
                  WHERE name = 'funky_cache_folder'";
        $success_3 = $pdo->exec($query) !== false;

        if ($success_1 && $success_2 && $success_3) {
            Flash::set('success', __('The settings have been updated.'));
            $message = sprintf('Cache settings were updated by :username.');
            Observer::notify('log_event', $message, 'funky_cache', 5);
        }
        else {
            Flash::set('error', 'An error has occured.');
            $message = sprintf('Updating cache settings by :username failed.');
            Observer::notify('log_event', $message, 'funky_cache', 2);
        }
        redirect(get_url('plugin/funky_cache/settings'));
    }

}
