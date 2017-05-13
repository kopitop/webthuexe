<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'desc', 'category_id', 'slug', 'img', 'price', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function approvedOrders()
    {
        return $this->orders()->where('status', config('vars.order.status.approved'));
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'car_id');
    }
}
