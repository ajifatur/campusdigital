<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'script';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_script';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_rak', 'script_title', 'script'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
