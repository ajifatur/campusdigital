<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rak';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_rak';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rak', 'rak_icon'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
