<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        echo openssl_encrypt("Alain",'aes-256-cbc',"Tendry",0,"aaaaaaaaaaaaaafb");

        echo openssl_decrypt("qGX3X7j8jytIqFschk29wA==" ,'aes-256-cbc',"Tendry",0,"aaaaaaaaaaaaaafb");
        // return view('welcome_message');
    }
}
