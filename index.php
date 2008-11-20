<?php

require_once 'models/FunkyCachePage.php';

Plugin::setInfos(array(
    'id'          => 'funky_cache',
    'title'       => 'Funky Cache', 
    'description' => 'Enables funky caching which makes your site ultra fast.', 
    'version'     => '0.1', 
    'license'     => 'MIT',
    'require_frog_version' => '0.9.4',
    'website'     => 'http://www.appelsiini.net/'
));

/* Stuff for backend. */
if (class_exists('AutoLoader')) {
    Plugin::addController('funky_cache', 'Cache');
    Observer::observe('page_edit_after_save', 'funky_cache_delete');
    function funky_cache_delete($page) {
        $data['url'] = '/' . $page->getUri() . URL_SUFFIX;
        if (($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
            $cache->delete();
        }
    }    
} else {
/* Stuff for frontend. */    

    global $__FROG_CONN__;
    Record::connection($__FROG_CONN__);
    
    Observer::observe('page_found',           'funky_cache_create');

    function funky_cache_create($page) {
        $data['url']  = str_replace(BASE_URL, '/', $page->url());
        $data['page'] = $page;
        if (!($cache = Record::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
            $cache = new FunkyCachePage($data);          
            $cache->save();
        }
    }

}