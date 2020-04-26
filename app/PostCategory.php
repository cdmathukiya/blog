<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{

    public $table = "post_category";

    public $timestamps = true;

    protected $fillable = ['post_id', 'category_id', 'created_at', 'updated_at']; 

    /**
     * Get the post category
     */
    public function category()
    {
        return $this->belongsToMany('App\Category', 'post_category');
    }
}
