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

if (!class_exists('Record')) {
    require_once dirname(__FILE__) . '/Record.php';    
}


class FunkyCachePage extends Record 
{
    const TABLE_NAME = 'funky_cache_page';
    
    public  $url;
    public  $created_on;
    public  $page;

    public function getColumns()
    {
        return array('url', 'created_on');
    }
        
    public function beforeSave()
    {
        $this->created_on = date('Y-m-d H:i:s');
        /* If directories do not exist create them. */
        $parts = explode('/', $this->path());
        $file  = array_pop($parts);

        /* If deep link create directories when needed. */
        $dir = '';
        foreach($parts as $part) {
            if(!is_dir($dir .= "/$part")) {
                mkdir($dir);
            }
        }
        /* Fix case when articles.html is created before articles/ */
        /* TODO This still creates on extra directory in the end.  */
        if (('archive' == $this->page->behavior_id) || ($this->page instanceof PageArchive)) {
            $dir .= '/' . basename($file, funky_cache_suffix());
            if(!is_dir($dir)) {
                mkdir($dir);
            }
        }
        return file_put_contents($this->path(), $this->content(), LOCK_EX);
    }

    public function beforeDelete()
    {
        return @unlink($this->path());
    }
    
    public function path() {
        return $_SERVER['DOCUMENT_ROOT'] . $this->url;
    }
    
    public function content() {
        ob_start();
        $this->page->_executeLayout();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
}

