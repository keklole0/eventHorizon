<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participation;

class ParticipationSeeder extends Seeder
{
    public function run(): void
    {
        Participation::factory()->count(50)->create();
    }
} 