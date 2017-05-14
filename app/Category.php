<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class Category extends Model
{
    use NestableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'danh_muc';

    protected $parent = 'danh_muc_cha_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten', 'ten_hien_thi', 'gioi_thieu', 'danh_muc_cha_id', 'ten_url'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'danh_muc_cha_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'danh_muc_cha_id', 'id');
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'danh_muc_id', 'id');
    }
}
