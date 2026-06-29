<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\ParentRequest;
use App\Models\User;
use App\Models\VaccinationSchedule;
use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VaccinationSystemSeeder extends Seeder
{
    public function run(): void
    {
        $vaccines = [
            ['name' => 'BCG', 'description' => 'Tuberculosis vaccine', 'recommended_age_days' => 0],
            ['name' => 'OPV', 'description' => 'Oral Polio Vaccine', 'recommended_age_days' => 60],
            ['name' => 'DPT', 'description' => 'Diphtheria, Pertussis, Tetanus', 'recommended_age_days' => 60],
            ['name' => 'Measles', 'description' => 'Measles vaccine', 'recommended_age_days' => 270],
            ['name' => 'Hepatitis B', 'description' => 'Hepatitis B vaccine', 'recommended_age_days' => 0],
        ];

        foreach ($vaccines as $vaccine) {
            Vaccine::firstOrCreate(['name' => $vaccine['name']], $vaccine);
        }

        Hospital::firstOrCreate(
            ['email' => 'cityhospital@vaccitrack.com'],
            [
                'name' => 'City General Hospital',
                'address' => '123 Health Street',
                'location' => 'Karachi',
                'phone' => '03001234567',
            ]
        );

        $parent = User::firstOrCreate(
            ['email' => 'parent@vaccitrack.com'],
            [
                'name' => 'Ahmed Khan',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $parent->hasRole('parent')) {
            $parent->assignRole('parent');
        }

        $child = Child::firstOrCreate(
            ['parent_id' => $parent->id, 'name' => 'Ali Khan'],
            [
                'date_of_birth' => now()->subMonths(6)->toDateString(),
                'gender' => 'male',
                'blood_group' => 'B+',
            ]
        );

        $bcg = Vaccine::where('name', 'BCG')->first();
        $opv = Vaccine::where('name', 'OPV')->first();
        $hospital = Hospital::first();

        VaccinationSchedule::firstOrCreate(
            [
                'child_id' => $child->id,
                'vaccine_id' => $bcg->id,
                'scheduled_date' => now()->addDays(3)->toDateString(),
            ],
            [
                'scheduled_time' => '10:00:00',
                'status' => 'upcoming',
            ]
        );

        VaccinationSchedule::firstOrCreate(
            [
                'child_id' => $child->id,
                'vaccine_id' => $opv->id,
                'scheduled_date' => now()->addDays(14)->toDateString(),
            ],
            [
                'scheduled_time' => '11:30:00',
                'status' => 'upcoming',
            ]
        );

        VaccinationSchedule::firstOrCreate(
            [
                'child_id' => $child->id,
                'vaccine_id' => $bcg->id,
                'scheduled_date' => now()->subMonths(2)->toDateString(),
            ],
            [
                'status' => 'completed',
            ]
        );

        ParentRequest::firstOrCreate(
            [
                'parent_id' => $parent->id,
                'child_id' => $child->id,
                'status' => 'pending',
            ],
            [
                'hospital_id' => $hospital?->id,
                'vaccine_id' => $opv->id,
                'preferred_date' => now()->addDays(10)->toDateString(),
                'message' => 'Please approve appointment for OPV vaccination.',
            ]
        );

        if ($hospital) {
            Booking::firstOrCreate(
                [
                    'parent_id' => $parent->id,
                    'child_id' => $child->id,
                    'hospital_id' => $hospital->id,
                    'vaccine_id' => $opv->id,
                    'booking_date' => now()->addDays(14)->toDateString(),
                ],
                [
                    'status' => 'confirmed',
                    'vaccination_status' => 'pending',
                ]
            );
        }
    }
}
