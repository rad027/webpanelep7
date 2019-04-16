<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class license implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $file = @file_get_contents('http://roldhandasalla.cf/license/'.$_SERVER['SERVER_NAME'].'.license.php');
        if($file === FALSE){
            return 0;
        }
        $file = json_decode($file);
        if($file->url[1] !== $value){
            return 0;
        }    
        if( time() >= strtotime($file->url[2]) ){
            return 0;
        }
        return 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You license is invalid. Please try again';
    }
}
