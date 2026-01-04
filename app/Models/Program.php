<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'age_from',
        'age_to',
    ];

    public function setAgeFromAttribute($age)
    {
        !empty($age) && is_numeric($age)
            ? $this->attributes['age_from'] = $age
            : $this->attributes['age_from'] = null;
    }

    public function setAgeToAttribute($age)
    {
        !empty($age) && is_numeric($age)
            ? $this->attributes['age_to'] = $age
            : $this->attributes['age_to'] = null;
    }
}
