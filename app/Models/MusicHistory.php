<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicHistory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['music_id', 'music_url', 'music_name', 'created_at'];

    /**
     * @var bool
     */
    public $timestamps = false;

}
