<?php

namespace App\Models\Cuisines;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuisineTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
}
