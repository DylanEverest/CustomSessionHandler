<?php

use App\Controllers\BaseController;

class Base2Controller extends BaseController 
{
    public function __construct()
    {
        $customSessionHandler = new CustomSessionHandler();

        session_set_save_handler($customSessionHandler, true);
    }
    
}
