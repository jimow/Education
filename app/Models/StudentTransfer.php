<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTransfer extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'student_transfers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'Level 1'  => 'Level 1',
        'Level 2'  => 'Level 2',
        'Complete' => 'Complete',
    ];

    protected $fillable = [
        'admission_number_id',
        'trasnsfer_from_id',
        'transfer_to_id',
        'principal_approval_transfer_from_id',
        'principal_approval_transfer_to_id',
        'initiated_by_id',
        'confirmed_by_id',
        'authorized_by_id',
        'status',
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

    public function trasnsfer_from()
    {
        return $this->belongsTo(School::class, 'trasnsfer_from_id');
    }

    public function transfer_to()
    {
        return $this->belongsTo(School::class, 'transfer_to_id');
    }

    public function principal_approval_transfer_from()
    {
        return $this->belongsTo(Principal::class, 'principal_approval_transfer_from_id');
    }

    public function principal_approval_transfer_to()
    {
        return $this->belongsTo(Principal::class, 'principal_approval_transfer_to_id');
    }

    public function initiated_by()
    {
        return $this->belongsTo(User::class, 'initiated_by_id');
    }

    public function confirmed_by()
    {
        return $this->belongsTo(User::class, 'confirmed_by_id');
    }

    public function authorized_by()
    {
        return $this->belongsTo(User::class, 'authorized_by_id');
    }
}
