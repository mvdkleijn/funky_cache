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

//require_once 'models/FunkyCachePage.php';

Plugin::setInfos(array(
    'id' => 'funky_cache',
    'title' => 'Funky Cache',
    'description' => 'Enables funky caching, making your site ultra fast.',
    'version' => '0.3.6-dev',
    'license' => 'MIT',
    'author' => 'Mika Tuupola',
    'require_wolf_version' => '0.7.5',
    'update_url' => 'http://www.appelsiini.net/download/frog-plugins.xml',
    'website' => 'http://www.appelsiini.net/'
));

AutoLoader::addFolder(PLUGINS_ROOT.'/funky_cache/models');

/* Stuff for backend. */
if (defined('CMS_BACKEND')) {

    AutoLoader::addFolder(dirname(__FILE__).'/lib');

    Plugin::addController('funky_cache', 'Cache');

    #Observer::observe('page_edit_after_save',   'funky_cache_delete_one');
    Observer::observe('page_edit_after_save', 'funky_cache_delete_all');
    Observer::observe('page_add_after_save', 'funky_cache_delete_all');
    Observer::observe('page_delete', 'funky_cache_delete_all');
    Observer::observe('view_page_edit_plugins', 'funky_cache_show_select');

    Observer::observe('comment_after_add', 'funky_cache_delete_all');
    Observer::observe('comment_after_edit', 'funky_cache_delete_all');
    Observer::observe('comment_after_delete', 'funky_cache_delete_all');
    Observer::observe('comment_after_approve', 'funky_cache_delete_all');
    Observer::observe('comment_after_unapprove', 'funky_cache_delete_all');

    Observer::observe('layout_after_edit', 'funky_cache_delete_all');
    Observer::observe('snippet_after_edit', 'funky_cache_delete_all');

    /* TODO Fix this to work with configurable cache folder. */


    function funky_cache_delete_one($page) {
        $data['url'] = '/'.$page->getUri().URL_SUFFIX;
        if (($cache = FunkyCachePage::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
            $cache->delete();
        }
    }


    function funky_cache_delete_all() {
        $cache = FunkyCachePage::findAllFrom('FunkyCachePage');
        foreach ($cache as $page) {
            $page->delete();
        }
        $message = sprintf('Cache was automatically cleared.');
        Observer::notify('log_event', $message, 'funky_cache', 7);
    }


    function funky_cache_show_select($page) {
        $enabled = isset($page->funky_cache_enabled) ?
                $page->funky_cache_enabled : funky_cache_by_default();
        print '
          <p><label for="page_funky_cache_enabled">'.__('Should cache').'</label>
            <select id="page_funky_cache_enabled" name="page[funky_cache_enabled]">
              <option value="0"'.($enabled == 0 ? ' selected="selected"' : '').'>'.__('No').'</option>
              <option value="1"'.($enabled == 1 ? ' selected="selected"' : '').'>'.__('Yes').'</option>
             </select>
          </p>';
    }

}
else {
    /* Stuff for frontend. */

    Observer::observe('page_found', 'funky_cache_create');
    Observer::observe('page_requested', 'funky_cache_debug');


    function funky_cache_debug($page) {
        if (DEBUG) {
            print "Cache miss... ";
        }
    }


    function funky_cache_create($page) {
        if ($page->funky_cache_enabled) {
            $data['url'] = URI_PUBLIC.CURRENT_URI.URL_SUFFIX;

            // Correct URL for frontpage - should become index.html
            if ($data['url'] == URI_PUBLIC.URL_SUFFIX) {
                $data['url'] = URI_PUBLIC.'index'.funky_cache_suffix();
            }
            
            $data['url'] = funky_cache_folder().$data['url'];
            $data['url'] = preg_replace('#//#', '/', $data['url']);
            $data['page'] = $page;

            if (!($cache = FunkyCachePage::findOneFrom('FunkyCachePage', 'url=?', array($data['url'])))) {
                $cache = new FunkyCachePage($data);
            }
            $cache->page = $page;
            $cache->save();
        }
        //}
    }

}


function funky_cache_suffix() {
    return Setting::get('funky_cache_suffix');
}


function funky_cache_by_default() {
    return Setting::get('funky_cache_by_default');
}


function funky_cache_folder() {
    $folder = '/'.Setting::get('funky_cache_folder').'/';
    $folder = preg_replace('#//*#', '/', $folder);
    return $folder;
}


function funky_cache_folder_is_root() {
    return '/' == funky_cache_folder();
}