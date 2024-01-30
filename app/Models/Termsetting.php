<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Termsetting extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'termsettings';

    protected $dates = [
        'begins',
        'ends',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'term',
        'begins',
        'ends',
        'year_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getBeginsAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBeginsAttribute($value)
    {
        $this->attributes['begins'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndsAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndsAttribute($value)
    {
        $this->attributes['ends'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}
