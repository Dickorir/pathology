<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public $fillable = ['name','address','age','gender','tel','email','id_no','village','location','district'];
}
