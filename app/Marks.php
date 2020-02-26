<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index_no', 'math', 'math_grade', 'eng','eng_grade','kiswa', 'kiswa_grade', 'sci','sci_grade','soc_stud', 'soc_stud_grade','tot_score', 'tot_grade',
    ];
}
