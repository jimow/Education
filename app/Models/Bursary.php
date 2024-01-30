<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bursary extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'bursaries';

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
        'school_id',
        'school_term',
        'year_id',
        'amount_paid',
        'cheque_no',
        'payment_code',
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
