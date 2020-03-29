<?php

namespace App\Http\Controllers;

class LoaderController {

    public function anyIndex($user=null)
    {
        return 'This is the default page and will respond to /controller and /controller/index    '.$user;
    }
}
