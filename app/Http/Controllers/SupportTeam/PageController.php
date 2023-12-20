<?php

namespace App\Http\Controllers\SupportTeam;

use Illuminate\Http\Request;
use App\Helpers\Qs;
use App\Http\Requests\Exam\ExamCreate;
use App\Http\Requests\Exam\ExamUpdate;
use App\Repositories\ExamRepo;
use App\Repositories\MarkRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\TeacherRepo;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Validator;

use App\Models\Exam;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Repositories\MessageRepo;

class PageController extends Controller
{
    protected $exam;
    protected $my_class;
    protected $teachers;
    protected $mark;
    protected $user;
    protected $message_repo;
    public function __construct(ExamRepo $exam, MyClassRepo $my_class, MarkRepo $mark, TeacherRepo $teachers, UserRepo $user, MessageRepo $message_repo)
    {
        // $this->middleware('teamSA', ['except' => ['destroy',] ]);
        // $this->middleware('super_admin', ['only' => ['destroy',] ]);

        $this->exam = $exam;
        $this->my_class = $my_class;
        $this->mark = $mark;
        $this->teachers = $teachers;
        $this->user = $user;
        $this->message_repo = $message_repo;
    }

    public function show($parameter)
    {
        // $d['exam'] = $this->exam->find($parameter);
        // $d['forms'] = $this->my_class->getAllForms();
        $d['types'] = Qs::getUserType();
        // $d['messages'] = $this->message_repo->getMessages(Auth::user()->phone);
        $d['formid'] = $parameter;
        $res_exam = $this->exam->getExambyFormId($parameter);
        if ($parameter === "1" || $parameter === "3") {
            $d['mp'] = 0;
            $d['mk'] = 0;
            $d['mpdev'] = 0;
            $d['mkdev'] = 0;
            $d['grade'] = "E";
            $d['grahp1'] = json_encode(array(array(0, 0), array(0, 0)));
            $d['exam'] = ["There is no exam data"];
            $d['stream'] = ["There is no stream"];
            $d['numberofstu'] = 0;
            $d['status'] = 0;
            $d['subjects'] = [];
        } else {
            $res_exam = $this->exam->getExambyFormId($parameter);
            $res_stream = $this->exam->getStreambyFormId($parameter);
            $d['exam'] = array();
            foreach ($res_exam as $val) {
                array_push($d['exam'], $val->exam->name);
            }
            $d['stream'] = array();
            $d['numberofstu'] = 0;
            foreach ($res_stream as $val) {
                array_push($d['stream'], $val->stream);
                $res_students = $this->exam->getStudentsbyFormId($val->id);
                $d['numberofstu'] += count($res_students);
            }
            $d['status'] = 1;
            $d['mp'] = mt_rand(0, 500) / 100;
            $d['mk']  = (mt_rand(0, 10000) / 100) . '%';
            $d['mpdev'] = mt_rand(0, 200) / 100;
            $d['mkdev'] = mt_rand(0, 200) / 100;
            $d['grade'] = $this->ran();
            $d['grahp1'] = $this->getarrayval();
            $d['subjects'] = [];
            $firstclassid = $res_stream[0]->id;
            $subjects = $this->exam->getsubjects($firstclassid);
            foreach ($subjects  as $val) {
                if (!$this->check_subject_id($d['subjects'], $val->subject->title)) {
                    continue;
                } else {
                    array_push($d['subjects'], $val->subject->title);
               }
            }

            $d['table1'] = [];
            foreach ($d['subjects'] as $val) {
                array_push( $d['table1'], [$val,mt_rand(0, 700) / 100,mt_rand(0, 700) / 100,$this->ran()]);
            }

            // $d['table2'] = [["Form West",1,1,0,1,1,0,1,1,23,]];

            $resval = $this->generateRandomArray(9);
        }

        return view('pages.support_team.pages', $d);
    }

    public function check_subject_id($arr1, $id)
    {
        foreach ($arr1 as $val) {
            if ($val == $id) {
                return false;
            }
        }
        return true;
    }

    public function ran()
    {
        $letters = ['A', 'B', 'C', 'D', 'E', 'D-', 'D+', 'C-', 'C+', 'B-', 'B+', 'A-'];
        $l = $letters[rand(0, count($letters) - 1)];
        return $l;
    }

    public function getarrayval()
    {
        $rows = 2;
        $columns = 2;

        $arr = array();

        for ($i = 0; $i < $rows; $i++) {
            $row = array();
            for ($j = 0; $j < $columns; $j++) {
                $row[] = rand(1, 4);
            }
            $arr[] = $row;
        }

        return json_encode($arr);
    }

    function generateRandomArray($columns) {
        $array = [];

        for ($i = 0; $i < 3; $i++) {
            $row = [];

            for ($j = 0; $j < $columns - 1; $j++) {
                $row[] = rand(0, 9); // Generate a random number between 0 and 9
            }

            if ($i === 0 || $i === 1) {
                $lastElement = array_sum($row); // Sum all elements in the row
                $row[] = $lastElement; // Set the last element of the row to the sum
            } else {
                for ($j = 0; $j < $columns - 1; $j++) {
                    $row[] = $array[0][$j] + $array[1][$j]; // Sum the corresponding elements from the first and second rows for the third row
                }
                $row[] = $array[0][$columns - 2] + $array[1][$columns - 2]; // Set the last element of the third row to the sum of the last elements from the first and second rows
            }

            $array[] = $row;
        }

        return $array;
    }

}