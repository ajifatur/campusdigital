<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_chapter';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_cc';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chapter_judul', 'dir_chapter', 'chapter_parent', 'chapter_icon', 'chapter_voucher', 'modified_at', 'chapter_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
