<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FolderKategori extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'folder_kategori';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_fk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folder_kategori', 'slug_kategori',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
