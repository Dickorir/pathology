<?php

namespace App\Http\Controllers;

use App\Pathology;
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

        $years= [];
        foreach ($dataLists as $dataList) {
            $years[] = $dataList;
        }
//        dd($years);

        $cancer_type = $request->q == null ? 'all' : $request->q;

        foreach ($years as $year){

            $dta = Carbon::create($year);

            $from    = Carbon::parse($dta)->startOfYear()->toDateTimeString();

            $to      = Carbon::parse($dta)->endOfYear() ->toDateTimeString();

            $pathologies = Pathology::groupBy('date','cancer_type')
                ->whereBetween('date',[$from, $to] )
                ->where('cancer_type', $cancer_type )
                ->select('date','cancer_type', DB::raw('count(*) as total'))
                ->get();

//            dd($pathologies);

            $path = [];
            foreach ($pathologies as $pathology){
                $path['cancer'] = $cancer_type;
                $path['year'] = $year;
                $path['total'] = $pathology->total;
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

//        $pathology = Pathology::with(['patient'])->groupBy('cancer_type')->select('cancer_type', DB::raw('count(*) as total'))->get();
//        return view('report.yearTotalPple', compact('pathologies','cancer_type'));

//        $path = [];
//        foreach ($pathologies as $pathology){
//            $path[] = array('year' => date('Y', strtotime($pathology->date)), 'total' => $pathology->total );
//        }

        $cancer = array('jsonarray' => $sub_array);

        return response()->json([
            'status'=>'200',
            'cancer'=> $cancer,
            'cancer_type' => $cancer_type
        ]);
    }

    public function cancerYear(Request $request,$id = null)
    {
//        dd($request);
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
//        $cancer['jsonarray'] = $main_array;
        dd($main_array);

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
}
