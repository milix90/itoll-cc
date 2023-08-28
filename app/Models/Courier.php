<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Courier extends Model
{
    use HasFactory;

    protected $primaryKey = 'courier_id';

    protected $fillable = [
        'identity_code',
        'username',
        'name',
        'email',
        'mobile',
        'active',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "courier_id");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->identity_code = Str::random(32);
        });
    }

    /*public function setIdentityCodeAttribute($value)
    {
        $this->attributes['identity_code'] = Str::random(32);
    }*/
}
