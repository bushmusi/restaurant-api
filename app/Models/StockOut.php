<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOut extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    protected $gaurded = [];
    protected $dates = ['deleted_at'];
}
