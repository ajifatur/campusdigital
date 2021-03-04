<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToolThumbnail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tool_thumbnail';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tool_thumbnail', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
