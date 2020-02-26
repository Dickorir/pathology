<?php

namespace App\Imports;

use App\School;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SchoolsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Http\RedirectResponse
    */
    public function collection(Collection $rows)
    {
//        dd($rows);
        foreach ($rows as $row)
        {
//            dd($row[1]);
//            dd($rows,82);
            // checking if all rows are included
            if ( ! isset($row[1])) {
                return back()->with('error', 'Ensure that all columns are matching.Download template for guide');
            }
//                        dd($row[1],23);
            // check and just the unrequired rows
            if ($row[0] == 'School Code'or $row[1] == null) {
                continue;
            }
//            dd($row[0]);
            $school = School::where('school_code',$row[0])->first();
//            dd($school);
            if (!is_null($school)) {
                return back()->with('error', 'Duplicate School code  ' . $row[0]);
            }
//            dd($school);

            $newcentre = School::create([
                'school_code'     => $row[0],
                'school_name'     => $row[1],
            ]);
//            dd('ruka');
        }
        return back()->with('success', 'Members imported successfully');
    }

//    public function model(array $row)
//    {
//        return new School([
//            //
//        ]);
//    }
}
