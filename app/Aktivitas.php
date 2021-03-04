<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aktivitas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_aktivitas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'aktivitas', 'aktivitas_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
