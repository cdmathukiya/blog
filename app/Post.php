<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    protected $fillable = ['name', 'sort_description', 'description', 'image', 'user_id', 'created_at', 'updated_at'];

    /**
     * Get the post category
     */
    public function category()
    {
        return $this->belongsToMany('App\Category', 'post_category');
    }
}
