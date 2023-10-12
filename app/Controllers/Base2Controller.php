<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Sessions\CustomSessionHandler;

class Base2Controller extends BaseController 
{
    public function __construct()
    {
        $customSessionHandler = new CustomSessionHandler('clustering','session');

        session_set_save_handler($customSessionHandler, true);
    }
    
}
