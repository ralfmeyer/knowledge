<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['data_id', 'file_path', 'sort', 'art'];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
