<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolderIcon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'folder_icon';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_fi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_icon', 'uploaded_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
