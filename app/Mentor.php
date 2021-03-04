<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mentor';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_mentor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_mentor', 'bidang_mentor', 'foto_mentor',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
