<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Repositories\StudentRepository;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentRecords = $this->studentRepository->getAllStudentRecords();
        return StudentResource::collection($studentRecords);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $studentRecord = $this->studentRepository->storeNewStudentRecord($request);
        return new StudentResource($studentRecord);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentRecord = $this->studentRepository->getStudentRecordById($id);
        return new StudentResource($studentRecord);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentRecord = $this->studentRepository->updateExistingStudentRecord($request, $id);
        return new StudentResource($studentRecord);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteStudent = $this->studentRepository->deleteStudentRecord($id);
            return new StudentResource($deleteStudent);
    }
}
