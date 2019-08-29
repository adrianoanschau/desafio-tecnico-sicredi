<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    /** @var array */
    protected $fillable = [
        'name',
        'document'
    ];
}
