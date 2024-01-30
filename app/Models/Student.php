<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Student extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'students';

    public const DISABILITY_SELECT = [
        'No'  => 'No',
        'Yes' => 'Yes',
    ];

    public const DAY_SCHOLAR_SELECT = [
        'Yes' => 'Yes',
        'No'  => 'No',
    ];

    public const ON_SCHOLARSHIP_SELECT = [
        'No'  => 'No',
        'Yes' => 'Yes',
    ];

    public const GENDER_SELECT = [
        'Male'   => 'Male',
        'Female' => 'Female',
    ];

    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'fullname',
        'admission_number',
        'father_phone_number',
        'mother_fullname',
        'mother_phone_number',
    ];

    protected $appends = [
        'father_death_certificate',
        'mother_death_certificate',
        'photo',
        'birth_certificate',
        'other_documents',
    ];

    public const PARENTAL_STATUS_SELECT = [
        'Both Alive'      => 'Both Alive',
        'Father Deceased' => 'Father Deceased',
        'Mother Deceased' => 'Mother Deceased',
        'Both Deceased'   => 'Both Deceased',
    ];

    public const STATUS_SELECT = [
        'Approved'     => 'Approved',
        'Not Approved' => 'Not Approved',
        'Transfered'   => 'Transfered',
        'Deserted'     => 'Deserted',
        'Died'         => 'Died',
        'Completed'    => 'Completed',
    ];

    protected $fillable = [
        'fullname',
        'gender',
        'date_of_birth',
        'ward_id',
        'nemis_number',
        'admission_number',
        'on_scholarship',
        'scholarship_amount',
        'scholarship_donor',
        'disability',
        'parental_status',
        'father_fullname',
        'father_phone_number',
        'mother_fullname',
        'mother_phone_number',
        'stream_id',
        'school_id',
        'form_id',
        'birth_certificate_number',
        'father_national_id_no',
        'mother_national_id_no',
        'status',
        'day_scholar',
        'registered_by_id',
        'approved_by_id',
        'guardian_fullname',
        'guardian_phone_number',
        'guardian_national',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function getFatherDeathCertificateAttribute()
    {
        $file = $this->getMedia('father_death_certificate')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getMotherDeathCertificateAttribute()
    {
        $file = $this->getMedia('mother_death_certificate')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function stream()
    {
        return $this->belongsTo(SchoolStream::class, 'stream_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function form()
    {
        return $this->belongsTo(StudentForm::class, 'form_id');
    }

    public function getBirthCertificateAttribute()
    {
        return $this->getMedia('birth_certificate')->last();
    }

    public function registered_by()
    {
        return $this->belongsTo(User::class, 'registered_by_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function getOtherDocumentsAttribute()
    {
        return $this->getMedia('other_documents');
    }
}
