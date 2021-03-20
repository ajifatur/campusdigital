<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelatihanThumbnail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelatihan_thumbnail';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pelatihan_thumbnail', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
