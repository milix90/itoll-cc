<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invoker extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoker_id';

    protected $fillable = [
        'identity_code',
        'username',
        'name',
        'email',
        'phone',
        'active',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "invoker_id");
    }

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->identity_code = Str::random(32);
        });
    }

    /*protected function identityCode(): Attribute
    {
        return new Attribute(
            set: fn(string $value) => Str::random(32)
        );
    }*/
}
