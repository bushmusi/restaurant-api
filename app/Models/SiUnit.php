<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SiUnit extends Model
{
    use HasFactory;
    use SoftDeletingTrait;
 
    protected $dates = ['deleted_at'];
}
