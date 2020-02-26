<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index_no', 'first_name', 'school_code','other_names',
    ];


    public function marks()
    {
        return $this->hasOne('App\Marks', 'index_no', 'index_no');
    }

    public function school()
    {
        return $this->hasOne('App\School', 'school_code', 'school_code');
    }
}
