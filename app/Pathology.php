<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    public $fillable = [
        'patient_id',
        'age',
        'gender',
        'hospital',
        'doctor_name',
        'request_form_name',
        'request_form_upload',
        'form_number',
        'date',
        'type_of_test',
        'specimen',
        'report',
        'report_upload',
        'clinical_history_notes',
        'cancer_type',
        'cancer_stage'
    ];

    public function patient()
    {
        return $this->hasOne('App\Patient', 'id', 'patient_id');
    }
}
