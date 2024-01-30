<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource(Student::with(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by'])->get());
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->all());

        if ($request->input('father_death_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('father_death_certificate'))))->toMediaCollection('father_death_certificate');
        }

        if ($request->input('mother_death_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('mother_death_certificate'))))->toMediaCollection('mother_death_certificate');
        }

        if ($request->input('photo', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($request->input('birth_certificate', false)) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate'))))->toMediaCollection('birth_certificate');
        }

        foreach ($request->input('other_documents', []) as $file) {
            $student->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('other_documents');
        }

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Student $student)
    {
        abort_if(Gate::denies('student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudentResource($student->load(['ward', 'stream', 'school', 'form', 'registered_by', 'approved_by']));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->all());

        if ($request->input('father_death_certificate', false)) {
            if (! $student->father_death_certificate || $request->input('father_death_certificate') !== $student->father_death_certificate->file_name) {
                if ($student->father_death_certificate) {
                    $student->father_death_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('father_death_certificate'))))->toMediaCollection('father_death_certificate');
            }
        } elseif ($student->father_death_certificate) {
            $student->father_death_certificate->delete();
        }

        if ($request->input('mother_death_certificate', false)) {
            if (! $student->mother_death_certificate || $request->input('mother_death_certificate') !== $student->mother_death_certificate->file_name) {
                if ($student->mother_death_certificate) {
                    $student->mother_death_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('mother_death_certificate'))))->toMediaCollection('mother_death_certificate');
            }
        } elseif ($student->mother_death_certificate) {
            $student->mother_death_certificate->delete();
        }

        if ($request->input('photo', false)) {
            if (! $student->photo || $request->input('photo') !== $student->photo->file_name) {
                if ($student->photo) {
                    $student->photo->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($student->photo) {
            $student->photo->delete();
        }

        if ($request->input('birth_certificate', false)) {
            if (! $student->birth_certificate || $request->input('birth_certificate') !== $student->birth_certificate->file_name) {
                if ($student->birth_certificate) {
                    $student->birth_certificate->delete();
                }
                $student->addMedia(storage_path('tmp/uploads/' . basename($request->input('birth_certificate'))))->toMediaCollection('birth_certificate');
            }
        } elseif ($student->birth_certificate) {
            $student->birth_certificate->delete();
        }

        if (count($student->other_documents) > 0) {
            foreach ($student->other_documents as $media) {
                if (! in_array($media->file_name, $request->input('other_documents', []))) {
                    $media->delete();
                }
            }
        }
        $media = $student->other_documents->pluck('file_name')->toArray();
        foreach ($request->input('other_documents', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $student->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('other_documents');
            }
        }

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Student $student)
    {
        abort_if(Gate::denies('student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $student->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
