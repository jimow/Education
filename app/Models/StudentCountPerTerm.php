<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCountPerTerm extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'student_count_per_terms';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TERM_SELECT = [
        'Term 1' => 'Term 1',
        'Term 2' => 'Term 2',
        'Term 3' => 'Term 3',
    ];

    protected $fillable = [
        'school_id',
        'count',
        'year_id',
        'term',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}
