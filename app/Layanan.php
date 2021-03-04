<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layanan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_layanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'layanan', 'layanan_caption', 'layanan_icon',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
