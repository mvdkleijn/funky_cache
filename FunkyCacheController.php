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
        
        if (!AuthUser::hasPermission('admin_view')) {
            redirect(URL_PUBLIC);
        }

        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/funky_cache/views/sidebar'));
    }


    function index() {
        $this->display('funky_cache/views/index', array(
            'pages' => FunkyCachePage::findAllFrom('FunkyCachePage', '1=1 ORDER BY created_on ASC')
        ));
    }


    function documentation() {
        $this->display('funky_cache/views/documentation');
    }


    function delete($id) {
        $cached_page = FunkyCachePage::findByIdFrom('FunkyCachePage', $id);
        if ($cached_page->delete()) {
            Flash::set('success', 'Page was deleted from cache.');
        }
        else {
            Flash::set('error', 'The cached page could not be deleted. Try manually from the commandline.');
        }
        $message = sprintf('Single cache entry was deleted by :username.');
        Observer::notify('log_event', $message, 'funky_cache', 5);
        redirect(get_url('plugin/funky_cache/'));
    }


    function clear() {
        $error = false;
        // We need to delete them one by one to make sure the filesystem is cleaned too.
        $pages = Record::findAllFrom('FunkyCachePage');
        foreach ($pages as $page) {
            if (!$page->delete()) {
                $error = true;
            }
        }
        
        if ($error === false) {
            Flash::set('success', 'Cache cleared successfully.');
        }
        else {
            Flash::set('error', 'One or more cached pages could not be deleted. Try manually from the commandline.');
        }
        $message = sprintf('Cache was cleared by :username.');
        Observer::notify('log_event', $message, 'funky_cache', 5);
        redirect(get_url('plugin/funky_cache/'));
    }


    function settings() {
        $settings = Plugin::getAllSettings('funky_cache');

        $this->display('funky_cache/views/settings', array(
            'funky_cache_by_default' => $settings['funky_cache_by_default'],
            'funky_cache_suffix' => $settings['funky_cache_suffix'],
            'funky_cache_folder' => $settings['funky_cache_folder']
        ));
    }


    function save() {
        $settings = array();
        $settings['funky_cache_by_default'] = $_POST['funky_cache_by_default'];
        $settings['funky_cache_suffix'] = $_POST['funky_cache_suffix'];
        $settings['funky_cache_folder'] = $_POST['funky_cache_folder'];
        
        if (Plugin::setAllSettings($settings, 'funky_cache')) {
            Flash::set('success', __('The cache settings have been updated.'));
            $message = sprintf('The cache settings were updated by :username.');
            Observer::notify('log_event', $message, 'funky_cache', 5);
        }
        else {
            Flash::set('error', 'The cache settings could not be updated due to an error.');
            $message = sprintf('An attempt by :username to update the cache settings failed.');
            Observer::notify('log_event', $message, 'funky_cache', 2);
        }
        redirect(get_url('plugin/funky_cache/settings'));
    }

}
