<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentBursaryRegister extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'student_bursary_registers';

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
        'term',
        'year_id',
        'amount_paid',
        'requested_by_id',
        'authorized_by_id',
        'admission_number_id',
        'payment_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function requested_by()
    {
        return $this->belongsTo(User::class, 'requested_by_id');
    }

    public function authorized_by()
    {
        return $this->belongsTo(User::class, 'authorized_by_id');
    }

    public function admission_number()
    {
        return $this->belongsTo(Student::class, 'admission_number_id');
    }
}
