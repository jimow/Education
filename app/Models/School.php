<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'schools';

    public static $searchable = [
        'phone_number',
        'email',
    ];

    public const UNIFORM_FEE_RADIO = [
        'Yes' => 'Yes',
        'No'  => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'gender_type_id',
        'category_id',
        'ward_id',
        'principal_id',
        'phone_number',
        'email',
        'postal_address',
        'physical_address',
        'physical_location',
        'code',
        'registered_by_id',
        'approved_by_id',
        'fees',
        'uniform_fee',
        'f_1_fee',
        'f_2_fee',
        'f_3_fee',
        'f_4_fee',
        'b_1_fee',
        'b_2_fee',
        'b_3_fee',
        'b_4_fee',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function gender_type()
    {
        return $this->belongsTo(SchoolGenderType::class, 'gender_type_id');
    }

    public function category()
    {
        return $this->belongsTo(SchoolCategory::class, 'category_id');
    }

    
    public function schoolPermissions()
    {
    return $this->belongsToMany(SchoolPermission::class, 'school_school_permission', 'school_id', 'school_permission_id');
    }


    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function principal()
    {
        return $this->belongsTo(Principal::class, 'principal_id');
    }

    public function registered_by()
    {
        return $this->belongsTo(User::class, 'registered_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
