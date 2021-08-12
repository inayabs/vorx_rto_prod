<?php

namespace App\Http\Controllers\Avetmiss;


use Bdt\Avetmiss\File;
use Bdt\Avetmiss\Nat\V8\Nat100;
// use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Model Query
use App\Models\Student\Student;

class NatProccessController extends Controller
{
    //
    public function __construct() {
        //
    }
    
    public function Nat80() { // Client (NAT00080) file
        $queryStudents = Student::with(['offer_letter.student_details', 'offer_letter.course_details'])->get();

    }

    public function Nat85() { // Client contact details (NAT00085) file
        dd('Nat 85');
    }

    public function Nat90() { // Disability (NAT00090) file
        dd('Nat 90');
    }

    public function Nat100() { // Prior educational achievement (NAT00100) file
        // $file_path = storage_path() . '/app/public/';
        $file = new File(new Nat100);

        // Start Foreach
            // Dataset
        $client_id = 'sasas';
        $prior_education_achievement = '3213';

        $validator = Validator::make([
            'client_id' => $client_id, // Empty String is not accepted as null
            'prior_education_achievement' => $prior_education_achievement, // Empty String is not accepted as null
        ], [
            'client_id' => 'avetmiss:nat100,client_id,10,not_null',
            'prior_education_achievement' => 'avetmiss:nat100,prior_education_achievement,3,not_null',
        ]);
        $isValid = $validator->passes();

        if ($isValid === true) {
            try {
                $row = $file->createRow();
                // Nat100
                $row->set('client_id', $client_id);
                $row->set('prior_education_achievement', $prior_education_achievement);

                $file->writeRow($row);
            } catch (\Exception $e) {
                // Display or log any errors.
                dd($e->getMessage());
            }

            $file->export(storage_path() . '/app/public/' . 'nat100.txt');
        } else {
            echo "There is a missing data";
        }

        // End Foreach
    }

    public function Nat120() { // Training activity (NAT00120) file
        dd('Nat 120');
    }

    public function Nat130() { // Program completed (NAT00130) file
        dd('Nat 130');
    }
}
