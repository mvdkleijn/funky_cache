<?php

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
        $this->display('funky_cache/views/index');
    }
    
    function settings() {
    	error_reporting(E_ALL);
		global $__FROG_CONN__;
    	$sql = "SELECT * FROM ".TABLE_PREFIX."setting WHERE name = 'funky_cache_by_default'";
		$stmt = $__FROG_CONN__->prepare($sql);
		$stmt->execute();
		$funky_cache_by_default = $stmt->fetchObject();
        $this->display('funky_cache/views/settings', array(
			'funky_cache_by_default' => $funky_cache_by_default->value
		));
		
    }
    
	function save() {
		error_reporting(E_ALL);
		$funky_cache_by_default = mysql_escape_string($_POST['funky_cache_by_default']);
        
        global $__FROG_CONN__;
        $sql = "UPDATE " . TABLE_PREFIX . "setting SET value='$funky_cache_by_default' WHERE name = 'funky_cache_by_default'"; 
        $PDO = $__FROG_CONN__->prepare($sql);
        $success = $PDO->execute() !== false;
                
        if ($success){
            Flash::set('success', __('The settings have been updated.'));
        } else {
            Flash::set('error', 'An error has occured.');
        }
        redirect(get_url('plugin/funky_cache/settings'));   
	}
    
    
}
