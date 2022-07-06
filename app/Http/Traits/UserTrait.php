<?php

namespace App\Http\Traits;

trait UserTrait
{
    public function stutus($success, $message)
    {
       $data = [
            'success' => $success,
            'message' => $message
        ];

       return $data;
    }
}
