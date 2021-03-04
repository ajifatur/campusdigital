<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagangSosialisasi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'magang_sosialisasi';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap', 'email', 'nomor_hp', 'lembaga', 'nama_lembaga', 'nama_ketua_lembaga', 'email_lembaga', 'nomor_telepon_lembaga', 'alamat_lembaga', 'ms_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
