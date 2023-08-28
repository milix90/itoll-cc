<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'invoker_id',
        'courier_id',
        'origin',
        'origin_address',
        'client_name',
        'client_mobile',
        'destination',
        'destination_address',
        'receiver_name',
        'receiver_mobile',
        'revoker_id',
        'revoker_desc',
        'deliver_estimate',
        'status',
    ];

    public function invoker(): BelongsTo
    {
        return $this->belongsTo(Invoker::class, "invoker_id");
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class, "courier_id");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->order_code = Str::uuid()->toString();
        });
    }
}
