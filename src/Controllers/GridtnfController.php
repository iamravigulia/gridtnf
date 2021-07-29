<?php

namespace edgewizz\gridtnf\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Edgewizz\Edgecontent\Models\ProblemSetQues;
use Edgewizz\Gridtnf\Models\GridtnfAns;
use Edgewizz\Gridtnf\Models\GridtnfQues;
use Illuminate\Http\Request;

class GridtnfController extends Controller
{
    public function store(Request $request){
        $pmQ = new GridtnfQues();
        $pmQ->question              = $request->question;
        $pmQ->format_title          = $request->format_title;
        $pmQ->difficulty_level_id   = $request->difficulty_level_id;
        $pmQ->hint                  = $request->hint;
        $pmQ->save();

        for($i = 1; $i <= 2; $i++ ){
            $answer         = 'answer_'.$i;
            $ans_correct    = 'ans_correct_'.$i;
            $eng_word       = 'eng_word'.$i;
            if($request->$answer && !is_null($request->$answer) && !empty($request->$answer)){
                $arrange = '0';
                if($request->$ans_correct){
                    $arrange = '1';
                }
                $ans = new GridtnfAns();
                $ans->question_id = $pmQ->id;
                $ans->answer      = $request->$answer;
                $ans->arrange     = $arrange;
                $ans->eng_word    = $request->$eng_word;
                $ans->save();
            }
        }
        if($request->problem_set_id && $request->format_type_id){
            $pbq = new ProblemSetQues();
            $pbq->problem_set_id = $request->problem_set_id;
            $pbq->question_id = $pmQ->id;
            $pbq->format_type_id = $request->format_type_id;
            $pbq->save();
        }
        return back();
    }
    public function csv_upload(Request $request){
        $file       = $request->file('file');
        $filename   = $file->getClientOriginalName();
        $extension  = $file->getClientOriginalExtension();
        $tempPath   = $file->getRealPath();
        $fileSize   = $file->getSize();
        $mimeType   = $file->getMimeType();
        // Valid File Extensions
        $valid_extension = array("csv");
        // 2MB in Bytes
        $maxFileSize = 2097152;
        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {
            // Check file size
            if ($fileSize <= $maxFileSize) {
                // File upload location
                $location = 'uploads/gridtnf';
                // Upload file
                $file->move($location, $filename);
                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);
                // Reading file
                $file = fopen($filepath, "r");
                $importData_arr = array();
                $i = 0;
                while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                    $num = count($filedata);
                    // Skip first row (Remove below comment if you want to skip the first row)
                    if ($i == 0) {
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    $insertData = array(
                        "question"      => $importData[1],
                        "true"          => $importData[2],
                        "false"         => $importData[3],
                        "level"         => $importData[4],
                        "comment"       => $importData[5],
                    );
                    // dd($insertData);
                    if ($insertData['question']) {
                        $pmQ = new GridtnfQues();
                        $pmQ->question              = $insertData['question'];
                        if($request->format_title){
                            $pmQ->format_title          = $request->format_title;
                        }
                        $pmQ->difficulty_level_id   = $request->difficulty_level_id;
                        if ($insertData['comment']) {
                            $pmQ->hint = $insertData['comment'];
                        }
                        if(!empty($insertData['level'])){
                            if($insertData['level'] == 'easy'){
                                $pmQ->difficulty_level_id = 1;
                            }else if($insertData['level'] == 'medium'){
                                $pmQ->difficulty_level_id = 2;
                            }else if($insertData['level'] == 'hard'){
                                $pmQ->difficulty_level_id = 3;
                            }
                        }
                        $pmQ->save();
                        if($request->problem_set_id && $request->format_type_id){
                            $pbq = new ProblemSetQues();
                            $pbq->problem_set_id    = $request->problem_set_id;
                            $pbq->question_id       = $pmQ->id;
                            $pbq->format_type_id    = $request->format_type_id;
                            $pbq->save();
                        }

                        $ans = new GridtnfAns();
                        $ans->question_id   = $pmQ->id;
                        $ans->answer        = 'true';
                        $ans->eng_word      = 'true';
                        $ans->arrange       = $insertData['true'];
                        $ans->save();

                        $ans = new GridtnfAns();
                        $ans->question_id   = $pmQ->id;
                        $ans->answer        = 'false';
                        $ans->eng_word      = 'false';
                        $ans->arrange       = $insertData['false'];
                        $ans->save();
                       
                    }
                    /*  */
                }
                // Session::flash('message', 'Import Successful.');
            } else {
                // Session::flash('message', 'File too large. File must be less than 2MB.');
            }
        } else {
            // Session::flash('message', 'Invalid File Extension.');
        }
        return back();
    }

    public function update($id, Request $request){
        $q = GridtnfQues::where('id', $id)->first();
        // dd($q);
        if($request->format_title){
            $q->format_title = $request->format_title;
        }
        $q->question = $request->question;
        $q->difficulty_level_id = $request->difficulty_level_id;
        $q->hint = $request->hint;
        // $q->level_id = $request->question_level;
        // $q->score = $request->question_score;
        // $q->hint = $request->question_hint;
        $q->save();
        $answers = GridtnfAns::where('question_id', $q->id)->get();
        foreach($answers as $ans){
            $inputAnswer = 'answer'.$ans->id;
            $inputArrange = 'ans_correct'.$ans->id;
            $inputEngWord = 'eng_word'.$ans->id;
            $ans->answer = $request->$inputAnswer;
            $ans->eng_word = $request->$inputEngWord;
            if($request->$inputArrange){
                $ans->arrange = '1';
            }else{
                $ans->arrange = '0';
            }
            $ans->save();
        }
        return back();
    }
    public function delete($id){
        $f = GridtnfQues::where('id', $id)->first();
        $f->delete();
        $ans = GridtnfAns::where('question_id', $f->id)->pluck('id');
        if($ans){
            foreach($ans as $a){
                $f_ans = GridtnfAns::where('id', $a)->first();
                $f_ans->delete();
            }
        }
        return back();
    }
    public function inactive($id){
        $f = GridtnfQues::where('id', $id)->first();
        $f->active = '0';
        $f->save();
        return back();
    }
    public function active($id){
        $f = GridtnfQues::where('id', $id)->first();
        $f->active = '1';
        $f->save();
        return back();
    }
}
