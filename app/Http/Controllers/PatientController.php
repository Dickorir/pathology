<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Pathology;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::orderBy('created_at')->paginate(5);
//        dd($patients);
        return view('pathology.patients', compact('patients'));
    }

    public function pathology()
    {
        $pathologies = Pathology::with(['patient'])->orderBy('created_at')->paginate(5);
        $pathologies_count = Pathology::count();
//        dd($pathologies_count);
        return view('pathology.index', compact('pathologies','pathologies_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pathology.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
//        $this->validator_school($request->all())->validate();

        $request_form = $this->uploadForm($request);
        $report_upload = $this->uploadReport($request);

        $request->request->add(['request_form_up' => $request_form]); //add request
        $request->request->add(['report_upload_up' => $report_upload]); //add request

//        dd($request);

        event(new Registered($info = $this->create_info($request->all())));

        if ($info) {
            return redirect('pathology')->with('success', trans('Pathology created'));
        } else {
            return redirect('pathology')->withInput()->with('error', trans('Pathology not created'));
        }
    }

    protected function create_info(array $data)
    {
//        dd($data,8);
        $date = Carbon::createFromFormat('d/m/Y', $data['date'])->toDateString();

        $repo = $this->storetext($data['report']);
        $notes = $this->storetext($data['clinical_history_notes']);
//        dd($notes,748);

        $data_patient = [
            'name' => $data['name'],
            'address' => $data['address'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'id_no' => $data['id_no'],
            'village' => $data['village'],
            'location' => $data['location'],
            'district' => $data['district'],
        ];
        $patient = Patient::create($data_patient);
//        dd($pat);
        $data_path = [
            'patient_id' => $patient->id,
            'hospital' => $data['hospital'],
            'doctor_name' => $data['doctor_name'],
            'request_form_name' => $data['request_form_name'],
            'request_form_upload' => $data['request_form_up'],
            'form_number' => $data['form_number'],
            'date' => $date,
            'type_of_test' => $data['type_of_test'],
            'specimen' => $data['specimen'],
            'report' => $repo,
            'report_upload' => $data['report_upload_up'],
            'clinical_history_notes' => $notes,
        ];

//        dd($data_path);
        $pathology = Pathology::create($data_path);

        LogActivity::addToLog('Pathology Request form:'.$pathology->request_form_name.'('.$pathology->id.') for '.$patient->name.'('.$patient->id.') info added Successfully');

        return $pathology->id;
    }

    public function storetext($detail)
    {

        $dom = new \domdocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('report');

        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/'. $image_name;

            file_put_contents($path, $data);

            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
        }

        $detail = $dom->savehtml();

        return $detail;
    }

    public function uploadReport($request, $id = null)
    {
//        dd($data, 'ups');
        $slug = str_slug('KNH_');
        $fileName = null;

//        dd($slug);
        //check if image exist
        if ($request->hasFile('report_upload')) {

            $image = $request->file('report_upload');

            $upload_dir = public_path('uploads/report_uploads/');
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // check if there is another file and the delete the file
            if ($id != null){
                $pathology = Pathology::with(['patient'])->where('id', '=', $id)->first();
                File::delete($upload_dir.$pathology->report_upload);
            }

            //get file name of image  and concatenate with 4 random integer for unique
            $fileName = $slug . rand(1111, 9999) . time() . '.' . $image->getClientOriginalExtension();

            // upload image to server
            try {//Uploading image
                //Uploading original image
                $image->move($upload_dir, $fileName);

            } catch (\Exception $e) {
                return $e->getMessage();
            }

            return $fileName;
        }

        return null;
    }
    public function uploadForm($request, $id=null)
    {
//        dd($id, 'ups');
        $slug = str_slug('KNhH_');
        $fileName = null;

        //check if image exist
        if ($request->hasFile('request_form_upload')) {
//            dd($slug);

            $image = $request->file('request_form_upload');

            $upload_dir = public_path('uploads/request_form_uploads/');
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }


            // check if there is another file and the delete the file
            if ($id != null){
                $pathology = Pathology::with(['patient'])->where('id', '=', $id)->first();
                File::delete($upload_dir.$pathology->request_form_upload);
            }
//            dd($pathology);

            //get file name of image  and concatenate with 4 random integer for unique
            $fileName = $slug . rand(1111, 9999) . time() . '.' . $image->getClientOriginalExtension();

            // upload image to server
            try {//Uploading image
                //Uploading original image
                $image->move($upload_dir, $fileName);

            } catch (\Exception $e) {
                return $e->getMessage();
            }

            return $fileName;
        }
//        dd('nje');

        return null;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Pathology $pathology, $id)
    {
        $pathology = $pathology->with(['patient'])->where('id', '=', $id)->first();
//        dd($pathology);
        return view('pathology.show', compact('pathology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Pathology $pathology, $id)
    {
        $pathology = $pathology->with(['patient'])->where('id', '=', $id)->first();
//        dd($pathology);
        return view('pathology.edit', compact('pathology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->toDateString();

        $request_form = $this->uploadForm($request, $id);
        $report_upload = $this->uploadReport($request, $id);

        $request->request->add(['request_form_up' => $request_form]); //add request
        $request->request->add(['report_upload_up' => $report_upload]); //add request

        $repo = $this->storetext($request->report);
        $notes = $this->storetext($request->clinical_history_notes);

        $histology = Pathology::where('id', $id)->first();
//        dd($histology);
        $data_patient = [
            'name' => $request->name,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'tel' => $request->tel,
            'email' => $request->email,
            'id_no' => $request->id_no,
            'village' => $request->village,
            'location' => $request->location,
            'district' => $request->district,
        ];

        $update = Patient::where('id', $histology->patient_id)->update($data_patient);

        $data_path = [
            'hospital' => $request->hospital,
            'doctor_name' => $request->doctor_name,
            'request_form_name' => $request->request_form_name,
            'request_form_upload' => $request->request_form_up,
            'form_number' => $request->form_number,
            'date' => $date,
            'type_of_test' => $request->type_of_test,
            'specimen' => $request->specimen,
            'report' => $repo,
            'report_upload' => $request->report_upload_up,
            'clinical_history_notes' => $notes,
        ];

        $histology = Pathology::where('id', $id)->update($data_path);
//        dd($admin);
        if ($histology) {
            return redirect('pathology')->with('success', trans('histology updated'));
        } else {
            return redirect('pathology')->withInput()->with('error', trans('histology not updated'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pathology $pathology)
    {
        //
    }
}
