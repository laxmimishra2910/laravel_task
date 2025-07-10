<?php 

use Illuminate\Support\Facades\Auth;

if(!function_exists('has_role'))
{
    function has_role(...$roles)
    {
        return Auth::check() && in_array(Auth::user()->role,$roles);
    }
}