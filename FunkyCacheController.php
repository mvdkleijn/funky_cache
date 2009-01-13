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
 
class FunkyCacheController extends PluginController
{
    function __construct() {
        AuthUser::load();
        if (!(AuthUser::isLoggedIn())) {
            redirect(get_url('login'));            
        }

        $this->setLayout('backend');
        if (version_compare(FROG_VERSION, '0.9.5', '<')) {
            $this->assignToLayout('sidebar', new View('../../../plugins/funky_cache/views/sidebar'));
        } else {
            $this->assignToLayout('sidebar', new View('../../plugins/funky_cache/views/sidebar'));
        }
    }

    function index() {
        $this->display('funky_cache/views/index', array(
            'cached_page' => Record::findAllFrom('FunkyCachePage', '1=1 ORDER BY created_on ASC')
        ));
    }
    
    function documentation() {
        $this->display('funky_cache/views/documentation');
    }
    
    function delete($id) {
        $cached_page = Record::findByIdFrom('FunkyCachePage', $id);
        if ($cached_page->delete()) {
            Flash::set('success', 'Page deleted from cache.');            
        } else {
            Flash::set('error', 'Could not delete cached page. Try manually from commandline.');
        }
        redirect(get_url('plugin/funky_cache/'));   
    }
    
    function clear() {
        $cached_page = Record::findAllFrom('FunkyCachePage');
        foreach ($cached_page as $page) {
            $page->delete();
        }
        Flash::set('success', 'Should have cleared cache.');
        redirect(get_url('plugin/funky_cache/'));   
    }
    
    function settings() {
        $this->display('funky_cache/views/settings', array(
			'funky_cache_by_default' => Setting::get('funky_cache_by_default'),
			'funky_cache_suffix'     => Setting::get('funky_cache_suffix'),
			'funky_cache_folder'     => Setting::get('funky_cache_folder')
		));
    }
    
	function save() {
		error_reporting(E_ALL);

		/* Setting::saveFromData() does not handle any errors so lets save manually. */
	    $pdo   = Record::getConnection();
		$table = TABLE_PREFIX . 'setting';
		
		$funky_cache_by_default = $pdo->quote($_POST['funky_cache_by_default']);
		$funky_cache_suffix     = $pdo->quote($_POST['funky_cache_suffix']);
		$funky_cache_folder     = $pdo->quote($_POST['funky_cache_folder']);
                  
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
                
        if ($success_1 && $success_2 && $success_3){
            Flash::set('success', __('The settings have been updated.'));
        } else {
            Flash::set('error', 'An error has occured.');
        }
        redirect(get_url('plugin/funky_cache/settings'));   
	}
    
}
