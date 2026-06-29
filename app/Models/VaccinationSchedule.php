<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VaccinationSchedule extends Model
{
    protected $guarded = []; 
    protected $table = 'vaccination_schedules';

   
    protected $fillable = [
        'child_id',
        'child_name', 
        'vaccine_id', 
        'scheduled_date',
        'scheduled_time',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
        ];
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'vaccination_schedule_id');
    }
}