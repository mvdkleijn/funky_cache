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
 
class FunkyCacheController extends PluginController
{
    function __construct() {
        AuthUser::load();
        if (!(AuthUser::isLoggedIn())) {
            redirect(get_url('login'));            
        }

        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../../plugins/funky_cache/views/sidebar'));
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
    	error_reporting(E_ALL);
		global $__FROG_CONN__;
		
		/* TODO is there an API to retrieve settings? */
    	$sql = "SELECT * FROM ".TABLE_PREFIX."setting WHERE name = 'funky_cache_by_default'";
		$stmt = $__FROG_CONN__->prepare($sql);
		$stmt->execute();
		$funky_cache_by_default = $stmt->fetchObject();
		
		$sql = "SELECT * FROM ".TABLE_PREFIX."setting WHERE name = 'funky_cache_suffix'";
		$stmt = $__FROG_CONN__->prepare($sql);
		$stmt->execute();
		$funky_cache_suffix = $stmt->fetchObject();
		
		$sql = "SELECT * FROM ".TABLE_PREFIX."setting WHERE name = 'funky_cache_folder'";
		$stmt = $__FROG_CONN__->prepare($sql);
		$stmt->execute();
		$funky_cache_folder = $stmt->fetchObject();

        $this->display('funky_cache/views/settings', array(
			'funky_cache_by_default' => $funky_cache_by_default->value,
			'funky_cache_suffix' => $funky_cache_suffix->value,
			'funky_cache_folder' => $funky_cache_folder->value
		));
		
    }
    
	function save() {
		error_reporting(E_ALL);
		$funky_cache_by_default = mysql_escape_string($_POST['funky_cache_by_default']);
		$funky_cache_suffix     = mysql_escape_string($_POST['funky_cache_suffix']);
		$funky_cache_folder     = mysql_escape_string($_POST['funky_cache_folder']);
        
        global $__FROG_CONN__;

        $sql = "UPDATE " . TABLE_PREFIX . "setting SET value='$funky_cache_by_default' WHERE name = 'funky_cache_by_default'"; 
        $PDO = $__FROG_CONN__->prepare($sql);
        $success_1 = $PDO->execute() !== false;

        $sql = "UPDATE " . TABLE_PREFIX . "setting SET value='$funky_cache_suffix' WHERE name = 'funky_cache_suffix'"; 
        $PDO = $__FROG_CONN__->prepare($sql);
        $success_2 = $PDO->execute() !== false;
        
        $sql = "UPDATE " . TABLE_PREFIX . "setting SET value='$funky_cache_folder' WHERE name = 'funky_cache_folder'"; 
        $PDO = $__FROG_CONN__->prepare($sql);
        $success_3 = $PDO->execute() !== false;
                
        if ($success_1 && $success_2 && $success_3){
            Flash::set('success', __('The settings have been updated.'));
        } else {
            Flash::set('error', 'An error has occured.');
        }
        redirect(get_url('plugin/funky_cache/settings'));   
	}
    
    
}
