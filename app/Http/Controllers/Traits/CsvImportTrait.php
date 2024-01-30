<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SpreadsheetReader;
use App\Models\County;
use App\Models\Ward;
use App\Models\year;
use App\Models\School;
use App\Models\Student;
use App\Models\SchoolCategory;
use App\Models\SchoolGenderType;
use App\Models\SchoolStream;
use App\Models\StudentForm;
use App\Models\User;
use App\Models\Principal;

trait CsvImportTrait
{
    public function processCsvImport(Request $request)
    {
        try {
            $filename = $request->input('filename', false);
            $path     = storage_path('app/csv_import/' . $filename);

            $hasHeader = $request->input('hasHeader', false);

            $fields = $request->input('fields', false);
          
            $fields = array_flip(array_filter($fields));
           
            $modelName = $request->input('modelName', false);
            $model     = "App\Models\\" . $modelName;

            $reader = new SpreadsheetReader($path);
            $insert = [];
            
            $skippedStudents = []; // Array to hold information about skipped students


            foreach ($reader as $key => $row) {
                if ($hasHeader && $key == 0) {
                    continue;
                }



                $tmp = [];
                foreach ($fields as $header => $k) {
                    if (isset($row[$k])) {
                        $tmp[$header] = $row[$k];
                    }
                }
                
                

                if ($modelName === 'County') {
                    $countyName = $tmp['name'];
                    
                    $county = County::where('name', $countyName)->first();
                  
                    if ($county) {
                        $tmp['county_id'] = $county->id;
                    }

                   // Log::info("Transformed row: " . json_encode($tmp));
                }
               
                
                if ($modelName === 'StudentBursaryRegister') {

                    
                    $studentname = $tmp['admission_number_id'];
                    
                    //$adm = $tmp['admission_number_id'];

                    //$admission = Student::where('admission_number', $adm);

                     

                  
                 // dd(gettype($tmp['admission_number_id']));

                    $student = Student::where('admission_number', $studentname)->first();
                    
                   // dd(!$student || $student->status === 0);
                    
                   // $student = Student::where('fullname', $studentname)->first();

                    // Check if student is not registered or not approved (approved field equals 0)
                    if (!$student && $student->status === 0) {
                        // Add to skipped list and skip this iteration
                        $skippedStudents[] = $studentname;

                        
                        continue;
                        
                    }
                
                    if ($student) {
                        $tmp['admission_number_id'] = $student->id;
                    }

                      $yearname = $tmp['year_id'];

                    $year = Year::where('year', $yearname)->first();

                    if ($year) {
                        $tmp['year_id'] = $year->id;
                    }

                   
                }

                if ($modelName === 'StudentBursaryPayment') {

                    $yearName = $tmp['year_id'];

                    $year = Year::where('year', $yearName)->first();

                    if ($year) {
                        $tmp['year_id'] = $year->id;
                    }

                   


                }


                if ($modelName === 'SchoolAttendance') {

                    $yearName = $tmp['year_id'];
                    
                    $year = Year::firstOrCreate(['year' => $yearName]); //->first();

                   // $schgender  = SchoolGenderType::firstOrCreate(['gender_type' => $schgendername]);

                  
                    if ($year) {
                        $tmp['year_id'] = $year->id;
                    }

                    $admission = $tmp['admission_number_id'];
                    // $admission = $tmp['admission_number_id'];
 
                     $adm = Student::where('admission_number', $admission)->first();
 
                     
 
                    if ($adm) {
                       $tmp['admission_number_id'] = $adm->id;
                     }

                   

                }
                if ($modelName === 'Student') {
                    $schoolName = $tmp['school_id'];
                    
                    
                    if (isset($tmp['date_of_birth'])) {
                        $tmp['date_of_birth'] = date('Y-m-d', strtotime($tmp['date_of_birth']));
                    } 
                    
                  
                    $school = School::firstOrCreate(['name' => $schoolName]); //where('name', $schoolName)->first();
                  
                    if ($school) {
                        $tmp['school_id'] = $school->id;
                    }

                    $formName = $tmp['form_id'];
                    
                    $form = StudentForm::firstOrCreate(['name' => $formName]); //'name', $formName)->first();
                  
                  
                    if ($form) {
                        $tmp['form_id'] = $form->id;
                    }


                    $form = $tmp['form_id'];
                    $id = $tmp['school_id'];
                    
                    $schid = School::find($id);//>code;
                    
                    $adm = $tmp['admission_number'];
                    $code = $schid->code;
            
                    $current_year = date("y");
                    if ($form == 1) {
                        $year = $current_year;
                    }
                    if ($form == 2) {
                        $year = $current_year - 1;
                    }
                    if ($form == 3) {
                        $year = $current_year - 2;
            
                    }
                    if ($form == 4) {
                        $year = $current_year - 3;
                    }
                    $tmp['admission_number'] = $code."-".$adm."/".$year;

                    $streamName = $tmp['stream_id'];
                    
                    $stream = SchoolStream::firstOrCreate(['name' => $streamName]); //->first();

                   // $schgender  = SchoolGenderType::firstOrCreate(['gender_type' => $schgendername]);
                  
                  
                    if ($stream) {
                        $tmp['stream_id'] = $stream->id;
                    }

                 /*  $userName = $tmp['registered_by_id'];
                    
                    $user= User::where('name', $userName)->first();
                  
                    if ($user) {
                        $tmp['registered_by_id'] = $user->id;
                    }
                    $userName1 = $tmp['approved_by_id'];

                    $user1 = User::where('name', $userName1)->first();

                    if ($user1) {
                        $tmp['approved_by_id'] = $user1->id;
                    }*/
                    $wardName = $tmp['ward_id'];
                    
                    $ward = Ward::firstOrCreate(['name' => $wardName]); //where('name', $wardName)->first();
                  
                    if ($ward) {
                        $tmp['ward_id'] = $ward->id;
                    }






                   // Log::info("Transformed row: " . json_encode($tmp));
                }
                if ($modelName === 'School') {



            
                   
                    $Email = $row[7]; 
                    $national = $row[8]; 
                    $phone = $row[9]; 
                    
                    
                  
    
                   


                   
    
                    $prname = $tmp['principal_id'];
                 
                    
                     $principal = Principal::firstOrCreate(['fullname' => $prname,'email'=> $Email,'national'=>$national , 'phone_number'=>$phone]);
                   
                    if($principal) {
                        $tmp['principal_id'] = $principal->id;
                    }


                    $schgendername = $tmp['gender_type_id'];
                    $schgender  = SchoolGenderType::firstOrCreate(['gender_type' => $schgendername]);

                    if($schgender) {
                        $tmp['gender_type_id'] = $schgender->id;
                    }

                    
                    $schcatname = $tmp['category_id'];
                    $schcat  = SchoolCategory::firstOrCreate(['category_name' => $schcatname]);

                    if($schcat) {
                        $tmp['category_id'] = $schcat->id;
                    }

                    $wardname = $tmp['ward_id'];
                    $ward  = Ward::firstOrCreate(['name' => $wardname]);

                    if($ward) {
                        $tmp['ward_id'] = $ward->id;
                    }
                }
                if ($modelName === 'Constituency') {
                    
                    $conName = $tmp['county_id'];
                    //$con = County::where('name', $conName)->first();
                   $con = County::firstOrCreate(['name' => $conName]);  // Changed this line to either get the first county with the given name or create a new one if it doesn't exist

                    if ($con) {
                        $tmp['county_id'] = $con->id;
                    }

                   // Log::info("Transformed row: " . json_encode($tmp));
                }


                if (count($tmp) > 0) {
                    $insert[] = $tmp;
                }
            }

            $for_insert = array_chunk($insert, 100);

            foreach ($for_insert as $insert_item) {
                $model::insert($insert_item);
            }
            
            $rows  = count($insert);
            $table = Str::plural($modelName);
           

            $rows  = count($insert);
            $table = Str::plural($modelName);


            $skippedMessage = '';
            if (count($skippedStudents) > 0) {
                $skippedMessage = ' However, the following students were not imported because they are either not registered or not approved: ' . implode(', ', $skippedStudents);
            }
          
          

            File::delete($path);
            
            session()->flash('message', "Imported {$rows} rows to {$table}.{$skippedMessage}");
    
            session()->flash('message', trans('global.app_imported_rows_to_table', ['rows' => $rows, 'table' => $table]));

            return redirect($request->input('redirect'));
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function parseCsvImport(Request $request)
    {
        $file = $request->file('csv_file');
        $request->validate([
            'csv_file' => 'mimes:csv,txt',
        ]);

        $path      = $file->path();
        $hasHeader = $request->input('header', false) ? true : false;

        $reader  = new SpreadsheetReader($path);
        $headers = $reader->current();
        $lines   = [];

        $i = 0;
        while ($reader->next() !== false && $i < 5) {
            $lines[] = $reader->current();
            $i++;
        }

        $filename = Str::random(10) . '.csv';
        $file->storeAs('csv_import', $filename);

        $modelName     = $request->input('model', false);
        $fullModelName = "App\Models\\" . $modelName;

        $model     = new $fullModelName();
        $fillables = $model->getFillable();

        $redirect = url()->previous();

        $routeName = 'admin.' . strtolower(Str::plural(Str::kebab($modelName))) . '.processCsvImport';

        return view('csvImport.parseInput', compact('headers', 'filename', 'fillables', 'hasHeader', 'modelName', 'lines', 'redirect', 'routeName'));
    }
}
