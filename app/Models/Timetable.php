<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_id',
        'program_id',
        'event_id',
        'organization_id',
        'city_id',
        'district_id',
        'time_start',
        'time_end',
        'date',
    ];

    public function setDayIdAttribute($day)
    {
        if ($day) {
            $dayModel = Day::where('name', $day)->first();
            $this->attributes['day_id'] = $dayModel->id;
        } else {
            $this->attributes['day_id'] = null;
        }
    }

    public function setTimeEndAttribute($time)
    {
        !empty($time) && strtotime($time)
            ? $this->attributes['time_end'] = $time
            : $this->attributes['time_end'] = null;
    }

    public function setDateAttribute($date)
    {
        !empty($date) && strtotime($date)
            ? $this->attributes['date'] = $date
            : $this->attributes['date'] = null;
    }
}
