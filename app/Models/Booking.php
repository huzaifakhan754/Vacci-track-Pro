<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'parent_request_id',
        'parent_id',
        'child_id',
        'hospital_id',
        'vaccine_id',
        'vaccination_schedule_id',
        'booking_date',
        'booking_time',
        'status',
        'vaccination_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function vaccinationSchedule(): BelongsTo
    {
        return $this->belongsTo(VaccinationSchedule::class, 'vaccination_schedule_id');
    }
}
