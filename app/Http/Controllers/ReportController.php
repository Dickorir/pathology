<?php

namespace App\Http\Controllers;

use App\Pathology;
use App\Patient;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-report');
    }
    public function generalReport()
    {
        $pathologies = Pathology::with(['patient'])->orderBy('created_at')->get();
        $pathologies_count = Pathology::count();
//        dd($pathologies_count);
        return view('report.general', compact('pathologies','pathologies_count'));
    }
    public function generalYearTotal($id)
    {
        $pathologies = Pathology::groupBy('date','cancer_type')->select('date','cancer_type', DB::raw('count(*) as total'))->get();
//        $pathologies = Pathology::groupBy('date')->select('date', DB::raw('count(*) as total'))->get();
        $cancer_type = 'All cancers';
//        $pathology = Pathology::with(['patient'])->groupBy('cancer_type')->select('cancer_type', DB::raw('count(*) as total'))->get();
        return view('report.yearTotalPple', compact('pathologies', 'cancer_type'));

    }
    public function peopleYear()
    {
        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();
//        dd($pathologies);
//        $cancer_type = 'blood';
//        $pathology = Pathology::with(['patient'])->groupBy('cancer_type')->select('cancer_type', DB::raw('count(*) as total'))->get();
        return view('report.peopleYear', compact( 'cancer_types'));
    }
    public function generalGraphCombined()
    {
        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();
        return view('report.generalGraphCombined', compact( 'cancer_types'));
    }

    public function peopleYearGraph()
    {
        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();
        return view('report.peopleYearGraph', compact( 'cancer_types'));
    }

    public function generalGraph($id = null)
    {
        $cancer_type = $id == null ? 'all' : $id;
        $pathologies = Pathology::with(['patient'])
            ->where(function ($query) use ($id) {
                if(isset($id)) {
                    $query->where('cancer_type',$id);
                };
            })
            ->groupBy('date')
            ->select('date', DB::raw('count(*) as total'))
            ->get();

//        $pathology = Pathology::with(['patient'])->groupBy('cancer_type')->select('cancer_type', DB::raw('count(*) as total'))->get();
//        return view('report.yearTotalPple', compact('pathologies','cancer_type'));

        $path = [];
        foreach ($pathologies as $pathology){
            $path[] = array('year' => date('Y', strtotime($pathology->date)), 'total' => $pathology->total );
        }

        $cancer = array('jsonarray' => $path);
//        dd($cancer);

        return response()->json([
            'status'=>'200',
            'cancer'=> $cancer,
            'cancer_type' => $cancer_type
        ]);
    }

    public function generalGraphPost(Request $request, $id = null)
    {
        $period = CarbonPeriod::create($request->start, $request->end);

// Iterate over the period
        $dates= [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y');
        }

        $dataLists  = collect( $dates )->unique();
//        dd($dataLists);

        $years= [];
        foreach ($dataLists as $dataList) {
            $years[] = $dataList;
        }
//        dd($years);

        $cancer_type = $request->q;

        foreach ($years as $year){

            $dta = Carbon::create($year);

            $from    = Carbon::parse($dta)->startOfYear()->toDateTimeString();

            $to      = Carbon::parse($dta)->endOfYear() ->toDateTimeString();

            $pathologies = Pathology::groupBy('date','cancer_type')
                ->whereBetween('date',[$from, $to] )
                ->where(function ($query) use ($cancer_type) {
                    if(isset($cancer_type)) {
                        $query->where('cancer_type', $cancer_type);
                    };
                })
                ->select('date','cancer_type', DB::raw('count(*) as total'))
                ->get();

//            dd($pathologies);

            $path = [];
            foreach ($pathologies as $pathology){
                $path['cancer'] = $cancer_type;
                $path['year'] = $year;
                $path['total'] = $pathologies->count();
            }
            if (empty($path)) {
                // list is empty
                $path['cancer'] = $cancer_type;
                $path['year'] = $year;
                $path['total'] = 0;
            }
            $sub_array[] = $path;

//                dd($kaka,90);

        }

        $cancer_type = $request->q == null ? 'all' : $request->q;
        $cancer = array('jsonarray' => $sub_array);
//        dd($cancer);

        return response()->json([
            'status'=>'200',
            'cancer'=> $cancer,
            'cancer_type' => $cancer_type
        ]);
    }

    public function cancerYear(Request $request,$id = null)
    {
//        dd($request, 67);
        $period = CarbonPeriod::create($request->start, $request->end);
// Iterate over the period
        $dates= [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y');
        }

        $dataLists  = collect( $dates )->unique();

        $years= [];
        foreach ($dataLists as $dataList) {
            $years[] = $dataList;
        }
//        dd($years);

        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();
//      dd($cancer_types);
        $main_array = [];
        foreach ($cancer_types as $cancer_type){
//            dd($cancer_type);
//        dd($years);
            foreach ($years as $year){

                $dta = Carbon::create($year);

                $from    = Carbon::parse($dta)->startOfYear()->toDateTimeString();

                $to      = Carbon::parse($dta)->endOfYear() ->toDateTimeString();

                $pathologies = Pathology::groupBy('date','cancer_type')
                    ->whereBetween('date',[$from, $to] )
                    ->where('cancer_type', $cancer_type->cancer_type )
                    ->select('date','cancer_type', DB::raw('count(*) as total'))
                    ->get();

//            dd($pathologies);

                $path = [];
                foreach ($pathologies as $pathology){
                    $path['cancer'] = $cancer_type->cancer_type;
                    $path['year'] = $year;
                    $path['total'] = $pathology->total;
                }
                if (empty($path)) {
                    // list is empty
//                    $path[$cancer_type->cancer_type] = array('year' => $year, 'total' => 0, 'cancer' => $cancer_type->cancer_type);
//                    $path[$year] = array('year' => $year, 'total' => 0, 'cancer' => $cancer_type->cancer_type);
                    $path['cancer'] = $cancer_type->cancer_type;
                    $path['year'] = $year;
                    $path['total'] = 0;
                }
                $sub_array[$year] = $path;

            }
//            $sub_array['cancer'] = $cancer_type->cancer_type;
            $main_array[] = $sub_array;
        }
        $cancer['jsonarray'] = $main_array;
//        dd($cancer);

        if ($request->ajax()) {
            return response()->json([
                'status' => '200',
                'cancer' => $cancer,
                'cancer_type' => $cancer_type
            ]);
        }


    }

    public function peopleYearAll()
    {
        $pathologies = Pathology::groupBy('date','cancer_type')->select('date','cancer_type', DB::raw('count(*) as total'))->get();
//        dd($pathologies);

        $path = [];
        foreach ($pathologies as $pathology){
            $path[] = array('year' => date('Y', strtotime($pathology->date)), 'total' => $pathology->total, 'cancer' => $pathology->cancer_type );
        }

        $cancer = array('jsonarray' => $path);
        dd($cancer);

        return response()->json([
            'status'=>'200',
            'cancer'=> $cancer,
            'cancer_type' => $cancer_type
        ]);
    }

    public  function cancerPatAge(Request $request)
    {
        if (is_null($request->startAge) or is_null($request->endAge)){
            return $this->cancerPatAges($request);
        }
//        dd($request->startAge);
        $ages = [];
        for ($i = $request->startAge; $i <= $request->endAge; $i++) {
            $ages[]=$i;
        }

        $thecancer = null;
        $fromDate = null;
        $toDate = null;
        $title = 'Cancer Distribution by age';
        if($request->has('_token')) {
            $thecancer = $request->q;
            $fromDate = Carbon::parse($request->start)->startOfYear()->toDateTimeString();
            $toDate = Carbon::parse($request->end)->endOfYear()->toDateTimeString();
            $title = $thecancer.' Cancer Distribution by age,'.date('Y', strtotime($fromDate)).' - '.date('Y', strtotime($toDate));
            $title = $thecancer.' Cancer Distribution by age '.$request->startAge.' to '.$request->endAge.','.date('Y', strtotime($fromDate)).' - '.date('Y', strtotime($toDate));
        }
        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();

        foreach ($ages as $age){

            $pathologies = Pathology::groupBy('age')
                ->where(function ($query) use ($thecancer) {
                    if(isset($thecancer)) {
                        $query->where('cancer_type', $thecancer);
                    };
                })
                ->where(function ($query) use ($fromDate,$toDate) {
                    if(isset($fromDate) and isset($toDate)) {
                        $query->whereBetween('date',[$fromDate, $toDate] );
                    };
                })
                ->where('age',$age)
                ->select('age', DB::raw('count(*) as total'))
                ->get();

//            dd($pathologies);

            $path = [];
            foreach ($pathologies as $pathology){
                $path['age'] = $age;
                $path['total'] = $pathologies->count();
            }
            if (empty($path)) {
                // list is empty
                $path['age'] = $age;
                $path['total'] = 0;
            }
            $sub_array[] = $path;

//                dd($kaka,90);

        }


        $cancer = array('jsonarray' => $sub_array);
//        dd($cancer);

        if ($request->ajax()) {
            return response()->json([
                'status' => '200',
                'cancer' => $cancer,
                'cancer_type' => $thecancer == null ? 'All' : $thecancer,
                'title' => $title,
                'search' => view('report.partials.cancerPatAge',compact('pathologies'))->render()
            ]);
        }

        return view('report.cancerPatientsAge', compact('pathologies','title', 'cancer_types'));

//        dd($pathologies);
    }
    public  function cancerPatAges($request)
    {
        $thecancer = null;
        $fromDate = null;
        $toDate = null;
        $title = 'Cancer Distribution by age';
        if($request->has('_token')) {
            $thecancer = $request->q;
            $fromDate = Carbon::parse($request->start)->startOfYear()->toDateTimeString();
            $toDate = Carbon::parse($request->end)->endOfYear()->toDateTimeString();
            $title = $thecancer.' Cancer Distribution by age,'.date('Y', strtotime($fromDate)).' - '.date('Y', strtotime($toDate));
        }

//        dd($thecancer);

        $cancer_types = Pathology::select('cancer_type')->groupBy('cancer_type')->get();

        $pathologies = Pathology::groupBy('age')
            ->where(function ($query) use ($thecancer) {
                if(isset($thecancer)) {
                    $query->where('cancer_type', $thecancer);
                };
            })
            ->where(function ($query) use ($fromDate,$toDate) {
                if(isset($fromDate) and isset($toDate)) {
                    $query->whereBetween('date',[$fromDate, $toDate] );
                };
            })
            ->select('age', DB::raw('count(*) as total'))
            ->get();

//        dd($pathologies);

        $path = [];
        foreach ($pathologies as $pathology){
            $path[] = array('age' => (int)$pathology->age, 'total' => (int)$pathology->total );
        }

        $cancer = array('jsonarray' => $path);
//        dd($cancer);

        if ($request->ajax()) {
            return response()->json([
                'status' => '200',
                'cancer' => $cancer,
                'cancer_type' => $thecancer == null ? 'All' : $thecancer,
                'title' => $title,
                'search' => view('report.partials.cancerPatAge',compact('pathologies'))->render()
            ]);
        }

        return view('report.cancerPatientsAge', compact('pathologies','title', 'cancer_types'));

//        dd($pathologies);
    }
}
