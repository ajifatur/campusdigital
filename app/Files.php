<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_folder', 'nama_file', 'jenis_file', 'ukuran_file', 'tipe_file', 'url', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
