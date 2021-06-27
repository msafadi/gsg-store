<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT  = 'draft';
    
    use HasFactory;
}
