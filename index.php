<?php

require_once 'models/FunkyCachePage.php';

Plugin::setInfos(array(
    'id'          => 'funky_cache',
    'title'       => 'Funky Cache', 
    'description' => 'Enables funky caching which makes your site ultra fast.', 
    'version'     => '0.2.2', 
    'license'     => 'MIT',
    'require_frog_version' => '0.9.4',
    'update_url'  => 'http://www.appelsiini.net/download/frog-plugins.xml',
    'website'     => 'http://www.appelsiini.net/'
));

/* Stuff for backend. */
if (class_exists('AutoLoader')) {
    
    Plugin::addController('funky_cache', 'Cache');
    
    Observer::observe('page_edit_after_save',   'funky_cache_delete_one');
    Observer::observe('page_add_after_save',    'funky_cache_delete_all');
    Observer::observe('page_delete',            'funky_cache_delete_all');
    Observer::observe('view_page_edit_plugins', 'funky_cache_show_select');
    
    function funky_cache_delete_one($page) {
        $data['url'] = '/' . $page->getUri() . URL_SUFFIX;
        if (($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
            $cache->delete();
        }
    }

    function funky_cache_delete_all() {
        $cache = Record::findAllFrom('FunkyCachePage');
        foreach ($cache as $page) {
            $page->delete();
        }
    }
    
    function funky_cache_show_select($page) {
        print '
          <p><label for="page_funky_cache_enabled">'.__('Should cache').'</label>
            <select id="page_funky_cache_enabled" name="page[funky_cache_enabled]">
              <option value="0"'.($page->funky_cache_enabled == 0 ? ' selected="selected"': '').'>'.__('No').'</option>
              <option value="1"'.($page->funky_cache_enabled == 1 ? ' selected="selected"': '').'>'.__('Yes').'</option>
             </select>
          </p>';
    }
        
} else {
/* Stuff for frontend. */    

    global $__FROG_CONN__;
    Record::connection($__FROG_CONN__);
    
    Observer::observe('page_found',           'funky_cache_create');
    Observer::observe('page_requested',       'funky_cache_debug');

    function funky_cache_debug($page) {
/*
        print "DEBUG";
        print "-" . $_SERVER['QUERY_STRING'] . "-";
        */
    }

    function funky_cache_create($page) {
        if ($page->funky_cache_enabled) {
            $data['url'] = "/" . $_SERVER['QUERY_STRING'];
            /* Supporting both /foo.html and /foo requires some jugling. */
            /* TODO: This jugling should be in model. */
            if (!strlen(URL_SUFFIX)) {
                $data['url'] .= '.html';
            }
            if ('/.html' == $data['url']) {
                $data['url'] = '/index.html';
            }
            if ('/' == $data['url']) {
                $data['url'] = '/index.html';
            }
            $data['page'] = $page;
            if (!($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
                $cache = new FunkyCachePage($data);          
            }
            $cache->page = $page;
            $cache->save();            
        }
    }

}
