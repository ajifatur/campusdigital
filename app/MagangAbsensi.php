<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagangAbsensi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'magang_absensi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ma';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_mm', 'kelas', 'ma_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
