<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cabang';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cabang';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_cabang', 'alamat_cabang', 'whatsapp_cabang', 'instagram_cabang', 'website_cabang', 'cabang_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
