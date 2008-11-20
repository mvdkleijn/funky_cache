<?php

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
        return file_put_contents($this->path(), $this->content(), LOCK_EX);
    }

    public function beforeDelete()
    {
        return unlink($this->path());
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

