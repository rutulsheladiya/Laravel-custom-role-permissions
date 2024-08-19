<?php

use Illuminate\Support\Facades\Auth;

function creatorId()
{
    if (Auth::user()->type == 'superadmin' || Auth::user()->type == 'company') {
        return Auth::user()->id;
    } else {
        return Auth::user()->created_by;
    }
}
