<?php

if (!class_exists('Record')) {
    require_once dirname(__FILE__) . '/Record.php';    
}


class FunkyCachePage extends Record 
{
    const TABLE_NAME = 'funky_cache_page';
    
    public function beforeSave()
    {
        /* TODO: Create static file here. */
        $this->created_on = date('Y-m-d H:i:s');        
        return true;
    }

    public function beforeDelete()
    {
        /* TODO: Remove static file here. */
        return true;
    }
    
}

