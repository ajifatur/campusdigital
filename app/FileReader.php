<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileReader extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_reader';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_fr';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_file', 'read_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
