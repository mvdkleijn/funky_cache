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
class FunkyCachePage extends Record {
    const TABLE_NAME = 'funky_cache_page';

    public $url;
    public $created_on;
    public $page;


    public function getColumns() {
        return array('url', 'created_on');
    }


    public function publicUrl() {
        $folder = Setting::get('funky_cache_folder').'/';
        $folder = preg_replace('#//*#', '/', $folder);
        $folder = preg_replace('#^/#', '', $folder);
        return str_replace($folder, '', $this->url);
    }


    public function beforeSave() {
        $this->created_on = date('Y-m-d H:i:s');
        /* If directories do not exist create them. */
        $parts = explode('/', trim($this->path(),'/'));
        $file = array_pop($parts);

        /* If deep link create directories when needed. */
        $dir = '/' . implode('/',$parts);
        if (!is_dir($dir)) {
            mkdir($dir,0755,true);
        }
        $htmlfile = $dir.'/'.$file;
        file_put_contents($htmlfile.'.gz', gzencode($this->content(), 6), LOCK_EX);
        return file_put_contents($htmlfile, $this->content(), LOCK_EX);
    }


    public function beforeDelete() {
        @unlink($this->path().'.gz');
        return @unlink($this->path());
    }


    public function path() {
        return realpath(CMS_ROOT).$this->url;
    }


    public function content() {
        ob_start();
        $this->page->_executeLayout();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}

