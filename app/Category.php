<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class Category extends Model
{
    use NestableTrait;

    protected $parent = 'parent_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'desc', 'parent_id', 'slug'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'category_id', 'id');
    }
}
