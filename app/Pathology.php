<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    public $fillable = ['patient_id','hospital','doctor_name','request_form_name','request_form_upload','form_number','date','type_of_test','specimen','report','report_upload','clinical_history_notes'];

    public function patient()
    {
        return $this->hasOne('App\Patient', 'id', 'patient_id');
    }
}
