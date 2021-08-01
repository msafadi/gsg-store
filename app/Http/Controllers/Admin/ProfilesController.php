<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        // SELECT * FROM ratings WHERE rateable_id = ? AND rateable_type = 'App\Models\Profile'
        return $profile->ratings;

    }

}
