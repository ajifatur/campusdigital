<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToolboxIcon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'toolbox_icon';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ti';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'toolbox_icon', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
