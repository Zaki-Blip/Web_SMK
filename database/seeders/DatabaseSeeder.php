<?php

namespace Database\Seeders;

use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Models\Spmb;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $profile = SchoolProfile::current();
        $profile->update(['school_name' => config('school.fallback.school_name')]);

        $settings = SiteSetting::current();
        $settings->update([
            'school_name' => config('school.fallback.school_name'),
            'address' => config('school.fallback.address'),
        ]);

        Spmb::current();
    }
}
