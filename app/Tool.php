<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tool';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_tool';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_toolbox', 'nama_tool', 'thumbnail_tool', 'ukuran_tool', 'tipe_tool', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
