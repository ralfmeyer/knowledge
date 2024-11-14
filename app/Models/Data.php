<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Data extends Model
{
    use HasFactory;

    protected $table = 'data';

    protected $fillable = [
        'bereich',
        'ueberschrift',
        'inhalt',
        'schlagworte',
        'berechtigung',
        'userid'
    ];

    public function getCreatedatAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
