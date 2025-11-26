<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'direction',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];




    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function makeDefault()
    {
        self::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }


    public function translations()
    {
        return $this->hasMany(Translation::class, 'locale', 'code');
    }
    public static function getDefaultDirection()
    {

        if (session()->has('locale')) {
            return self::where('code', session('locale'))->first()->direction;
        }
        return self::where('is_default', true)->first()?->direction ?? 'ltr';
    }
}
