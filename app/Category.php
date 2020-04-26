<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = true;

    public $table = "category";

    protected $fillable = ['name', 'created_at', 'updated_at'];
}
