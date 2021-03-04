<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileThumbnail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_thumbnail';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ft';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_thumbnail', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
