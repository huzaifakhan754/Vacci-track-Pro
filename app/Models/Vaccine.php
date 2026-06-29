<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vaccine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_available',
        'recommended_age_days',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    public function vaccinationSchedules(): HasMany
    {
        return $this->hasMany(VaccinationSchedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
