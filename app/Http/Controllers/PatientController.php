<?php

namespace App\Http\Controllers;

use App\Pathology;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
//        dd($pathologies);
        return view('pathology.index', compact('pathologies'));
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

        $request->request->add(['request_form' => $request_form]); //add request
        $request->request->add(['report_upload' => $report_upload]); //add request

        event(new Registered($info = $this->create_info($request->all())));

        if ($info) {
            return redirect('pathology')->with('success', trans('Pathology created'));
        } else {
            return redirect('pathology')->withInput()->with('error', trans('Pathology not created'));
        }
    }

    protected function create_info(array $data)
    {
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
        $pat = Patient::create($data_patient);
//        dd($pat);
        $data_path = [
            'patient_id' => $pat->id,
            'hospital' => $data['hospital'],
            'doctor_name' => $data['doctor_name'],
            'request_form_name' => $data['request_form_name'],
            'request_form_upload' => $data['request_form'],
            'form_number' => $data['form_number'],
            'date' => $date,
            'type_of_test' => $data['type_of_test'],
            'specimen' => $data['specimen'],
            'report' => $repo,
            'report_upload' => $data['report_upload'],
            'clinical_history_notes' => $notes,
        ];

//        dd($data_path);
        Pathology::create($data_path);

        return $pat->id;
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

    public function uploadReport($request)
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
    public function uploadForm($request)
    {
//        dd($data, 'ups');
        $slug = str_slug('KNH_');
        $fileName = null;

//        dd($slug);
        //check if image exist
        if ($request->hasFile('request_form_upload')) {

            $image = $request->file('request_form_upload');

            $upload_dir = public_path('uploads/request_form_uploads/');
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
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
    public function edit(Pathology $pathology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pathology $pathology)
    {
        //
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
