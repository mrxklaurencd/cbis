<?php

namespace Database\Seeders;

use App\Models\BloodBankLocation;
use App\Models\DonationSchedule;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facility = Facility::firstOrCreate(
            ['code' => 'FAC-001'],
            [
                'name' => 'City Blood Center',
                'type' => 'blood_bank',
                'contact_person' => 'Facility Facilitator',
                'contact_number' => '09170000000',
                'email' => 'facility@cbis.local',
                'address' => 'Sample City',
                'is_active' => true,
            ]
        );

        $facilitator = User::firstOrCreate(
            ['email' => 'facility.admin@cbis.local'],
            [
                'name' => 'Facility Facilitator',
                'password' => Hash::make('password'),
                'facility_id' => $facility->id,
                'is_active' => true,
            ]
        );
        $facilitator->forceFill([
            'name' => 'Facility Facilitator',
            'facility_id' => $facility->id,
            'is_active' => true,
        ])->save();
        $facilitator->syncRoles(['Facilitator']);

        $medicalStaff = User::firstOrCreate(
            ['email' => 'medical.staff@cbis.local'],
            [
                'name' => 'Medical Staff Nurse',
                'password' => Hash::make('password'),
                'facility_id' => $facility->id,
                'is_active' => true,
            ]
        );
        $medicalStaff->forceFill([
            'facility_id' => $facility->id,
            'is_active' => true,
        ])->save();
        $medicalStaff->syncRoles(['Medical Staff / Nurse']);

        $legacyMedTech = User::withTrashed()->firstWhere('email', 'medtech@cbis.local');

        if ($legacyMedTech !== null) {
            $legacyMedTech->forceFill([
                'name' => 'Medical Staff Nurse',
                'facility_id' => $facility->id,
                'is_active' => true,
            ]);

            if ($legacyMedTech->trashed()) {
                $legacyMedTech->restore();
            }

            $legacyMedTech->save();
            $legacyMedTech->syncRoles(['Medical Staff / Nurse']);
        }

        $this->seedMapSamples();
    }

    private function seedMapSamples(): void
    {
        $samples = [
            [
                'code' => 'FAC-SAMPLE-001',
                'name' => 'Negros First Blood Center',
                'type' => 'blood_bank',
                'contact_person' => 'Maria Santos',
                'contact_number' => '09171234501',
                'email' => 'bacolod.sample@cbis.local',
                'address' => 'Lacson Street, Bacolod City, Negros Occidental',
                'latitude' => 10.6765000,
                'longitude' => 122.9509000,
                'event_latitude' => 10.6689000,
                'event_longitude' => 122.9497000,
                'location_photo' => 'images/cbis-samples/bacolod-blood-center.svg',
                'event_photo' => 'images/cbis-samples/bacolod-donation-drive.svg',
                'event_title' => 'Bacolod Community Blood Donation Drive',
                'event_type' => 'blood_donation',
                'event_day_offset' => 5,
                'venue' => 'Bacolod City Public Plaza',
            ],
            [
                'code' => 'FAC-SAMPLE-002',
                'name' => 'Silay Community Blood Station',
                'type' => 'blood_bank',
                'contact_person' => 'Jun Alvarez',
                'contact_number' => '09171234502',
                'email' => 'silay.sample@cbis.local',
                'address' => 'Rizal Street, Silay City, Negros Occidental',
                'latitude' => 10.8002000,
                'longitude' => 122.9779000,
                'event_latitude' => 10.8026000,
                'event_longitude' => 122.9834000,
                'location_photo' => 'images/cbis-samples/silay-blood-station.svg',
                'event_photo' => 'images/cbis-samples/silay-bloodletting.svg',
                'event_title' => 'Silay Heritage Bloodletting Activity',
                'event_type' => 'bloodletting',
                'event_day_offset' => 9,
                'venue' => 'Silay Civic Center',
            ],
            [
                'code' => 'FAC-SAMPLE-003',
                'name' => 'Bago City Donation Hub',
                'type' => 'blood_bank',
                'contact_person' => 'Leah Villanueva',
                'contact_number' => '09171234503',
                'email' => 'bago.sample@cbis.local',
                'address' => 'Rafael Salas Drive, Bago City, Negros Occidental',
                'latitude' => 10.5377000,
                'longitude' => 122.8384000,
                'event_latitude' => 10.5333000,
                'event_longitude' => 122.8332000,
                'location_photo' => 'images/cbis-samples/bago-donation-hub.svg',
                'event_photo' => 'images/cbis-samples/bago-donation-day.svg',
                'event_title' => 'Bago City Donation Day',
                'event_type' => 'blood_donation',
                'event_day_offset' => 14,
                'venue' => 'Bago City Coliseum',
            ],
            [
                'code' => 'FAC-SAMPLE-004',
                'name' => 'San Carlos Blood Services Desk',
                'type' => 'blood_bank',
                'contact_person' => 'Carlo Mendoza',
                'contact_number' => '09171234504',
                'email' => 'sancarlos.sample@cbis.local',
                'address' => 'Locsin Street, San Carlos City, Negros Occidental',
                'latitude' => 10.4869000,
                'longitude' => 123.4145000,
                'event_latitude' => 10.4915000,
                'event_longitude' => 123.4094000,
                'location_photo' => 'images/cbis-samples/san-carlos-desk.svg',
                'event_photo' => 'images/cbis-samples/san-carlos-mobile-drive.svg',
                'event_title' => 'San Carlos Mobile Blood Drive',
                'event_type' => 'blood_donation',
                'event_day_offset' => 18,
                'venue' => 'San Carlos City Auditorium',
            ],
            [
                'code' => 'FAC-SAMPLE-005',
                'name' => 'Dumaguete Partner Blood Center',
                'type' => 'blood_bank',
                'contact_person' => 'Ana Dela Cruz',
                'contact_number' => '09171234505',
                'email' => 'dumaguete.sample@cbis.local',
                'address' => 'Perdices Street, Dumaguete City, Negros Oriental',
                'latitude' => 9.3068000,
                'longitude' => 123.3054000,
                'event_latitude' => 9.3122000,
                'event_longitude' => 123.3019000,
                'location_photo' => 'images/cbis-samples/dumaguete-blood-center.svg',
                'event_photo' => 'images/cbis-samples/dumaguete-campus-drive.svg',
                'event_title' => 'Dumaguete Campus Blood Donation',
                'event_type' => 'bloodletting',
                'event_day_offset' => 23,
                'venue' => 'Dumaguete City Quadrangle',
            ],
        ];

        foreach ($samples as $sample) {
            $facility = Facility::updateOrCreate(
                ['code' => $sample['code']],
                [
                    'name' => $sample['name'],
                    'type' => $sample['type'],
                    'contact_person' => $sample['contact_person'],
                    'contact_number' => $sample['contact_number'],
                    'email' => $sample['email'],
                    'address' => $sample['address'],
                    'is_active' => true,
                ]
            );

            BloodBankLocation::updateOrCreate(
                ['facility_id' => $facility->id],
                [
                    'latitude' => $sample['latitude'],
                    'longitude' => $sample['longitude'],
                    'address' => $sample['address'],
                    'contact_number' => $sample['contact_number'],
                    'photo_path' => $sample['location_photo'],
                ]
            );

            $startAt = Carbon::now()->addDays($sample['event_day_offset'])->setTime(8, 30);
            $endAt = $startAt->copy()->addHours(5);

            DonationSchedule::updateOrCreate(
                [
                    'facility_id' => $facility->id,
                    'title' => $sample['event_title'],
                ],
                [
                    'event_type' => $sample['event_type'],
                    'event_date' => $startAt->toDateString(),
                    'start_time' => $startAt->format('H:i:s'),
                    'end_time' => $endAt->format('H:i:s'),
                    'start_at' => $startAt,
                    'end_at' => $endAt,
                    'venue' => $sample['venue'],
                    'latitude' => $sample['event_latitude'],
                    'longitude' => $sample['event_longitude'],
                    'description' => 'Sample public event for CBIS map demonstration and donor registration testing.',
                    'photo_path' => $sample['event_photo'],
                    'contact_person' => $sample['contact_person'],
                    'contact_number' => $sample['contact_number'],
                    'is_public' => true,
                    'status' => 'planned',
                ]
            );
        }
    }
}
