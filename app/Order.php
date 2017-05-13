<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'begin', 'end'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'car_id', 'user_id', 'begin', 'end', 'total', 'status'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePendingOrders($query)
    {
        return $query->where('status', config('vars.order.status.pending'));
    }

    public function scopeApprovedOrders($query)
    {
        return $query->where('status', config('vars.order.status.approved'));
    }

    public function scopeRejectedOrders($query)
    {
        return $query->where('status', config('vars.order.status.rejected'));
    }

    public function scopeToday($query)
    {
        return $query->where('begin', \Carbon\Carbon::today())
            ->where('end', \Carbon\Carbon::today());
    }
}
