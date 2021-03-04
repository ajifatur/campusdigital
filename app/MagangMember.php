<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagangMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'magang_member';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_mm';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'alamat_lengkap', 'email', 'nomor_hp', 'satuan_pendidikan', 'asal_satuan_pendidikan', 'jurusan', 'alamat_satuan_pendidikan', 'kelas', 'pas_foto', 'kartu_identitas', 'status_magang', 'password', 'mm_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
