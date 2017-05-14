<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'xe';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ten', 'ten_hien_thi', 'gioi_thieu', 'danh_muc_id', 'ten_url', 'anh', 'gia', 'trang_thai'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'danh_muc_id', 'id');
    }

    public function approvedOrders()
    {
        return $this->orders()->where('trang_thai', config('vars.order.status.approved'));
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'xe_id');
    }
}
