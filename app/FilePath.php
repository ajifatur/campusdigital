<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilePath extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_path';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_fp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'tabel', 'field',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
