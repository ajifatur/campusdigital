<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pelatihan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pelatihan', 'kategori_pelatihan', 'nomor_pelatihan', 'deskripsi_pelatihan', 'fee_member', 'fee_non_member', 'trainer', 'kode_trainer', 'tempat_pelatihan', 'tanggal_pelatihan_from', 'tanggal_pelatihan_to', 'tanggal_sertifikat_from', 'tanggal_sertifikat_to', 'materi_pelatihan', 'total_jam_pelatihan'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
