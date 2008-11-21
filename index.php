<?php

require_once 'models/FunkyCachePage.php';

Plugin::setInfos(array(
    'id'          => 'funky_cache',
    'title'       => 'Funky Cache', 
    'description' => 'Enables funky caching which makes your site ultra fast.', 
    'version'     => '0.2', 
    'license'     => 'MIT',
    'require_frog_version' => '0.9.4',
    'website'     => 'http://www.appelsiini.net/'
));

/* Stuff for backend. */
if (class_exists('AutoLoader')) {
    
    Plugin::addController('funky_cache', 'Cache');
    
    Observer::observe('page_edit_after_save', 'funky_cache_delete');
    Observer::observe('view_page_edit_plugins', 'funky_cache_show_select');
    
    function funky_cache_delete($page) {
        $data['url'] = '/' . $page->getUri() . URL_SUFFIX;
        if (($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
            $cache->delete();
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

    function funky_cache_create($page) {
        if ($page->funky_cache_enabled) {
            $data['url']  = str_replace(BASE_URL, '/', $page->url());
            $data['page'] = $page;
            if (!($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
                $cache = new FunkyCachePage($data);          
            }
            $cache->page = $page;
            $cache->save();            
        }
    }

}