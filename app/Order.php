<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hoa_don';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'bat_dau', 'ket_thuc'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'xe_id', 'user_id', 'bat_dau', 'ket_thuc', 'tong_cong', 'trang_thai'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'xe_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePendingOrders($query)
    {
        return $query->where('trang_thai', config('vars.order.status.pending'));
    }

    public function scopeApprovedOrders($query)
    {
        return $query->where('trang_thai', config('vars.order.status.approved'));
    }

    public function scopeRejectedOrders($query)
    {
        return $query->where('trang_thai', config('vars.order.status.rejected'));
    }

    public function scopeToday($query)
    {
        return $query->where('bat_dau', \Carbon\Carbon::today())
            ->orWhere('ket_thuc', \Carbon\Carbon::today());
    }
}
