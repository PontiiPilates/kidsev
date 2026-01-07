<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

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
