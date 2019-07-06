<?php namespace App\Repositories;


use App\Student;
use Bosnadev\Repositories\Eloquent\Repository;

class StudentRepository extends Repository
{
    public function model()
    {
        return 'App\Student';
    }

    public function getAllStudentRecords()
    {
        return $this->model->orderBy('id', 'desc')->paginate(15);
    }

    public function storeNewStudentRecord($request)
    {
        $studentRecord = new $this->model;
        $studentRecord->create($request->input());
        return $studentRecord;
    }

    public function updateExistingStudentRecord($request, $id)
    {
        $studentRecord = $this->model->where('id', $id)->first();
        $studentRecord->update($request->input());
        return $studentRecord;
    }

    public function getStudentRecordById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    public function deleteStudentRecord($id)
    {
        $deleteStudent = $this->model->where('id', $id)->first();
        $deleteStudent->delete();
        return $deleteStudent;

    }

}
