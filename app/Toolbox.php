<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toolbox extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'toolbox';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_toolbox';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_toolbox', 'dir_toolbox', 'toolbox_parent', 'toolbox_icon', 'modified_at', 'toolbox_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
