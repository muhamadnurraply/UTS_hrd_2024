<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [
        'name', 'gender', 'phone', 'address', 'email', 'status', 'hired_on',
    ];
    
}


