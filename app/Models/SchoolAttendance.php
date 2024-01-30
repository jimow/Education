<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolAttendance extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'school_attendances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const SCHOOL_TERM_SELECT = [
        'Term 1' => 'Term 1',
        'Term 2' => 'Term 2',
        'Term 3' => 'Term 3',
    ];

    protected $fillable = [
        'admission_number_id',
        'year_id',
        'school_term',
        'prepared_by_id',
        'confirmed_by_id',
        'school_name_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function admission_number()
    {
        return $this->belongsTo(Student::class, 'admission_number_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function prepared_by()
    {
        return $this->belongsTo(User::class, 'prepared_by_id');
    }

    public function confirmed_by()
    {
        return $this->belongsTo(User::class, 'confirmed_by_id');
    }

    public function school_name()
    {
        return $this->belongsTo(School::class, 'school_name_id');
    }
}
