<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $verticals = [
            'Fintech', 'HealthTech', 'EdTech', 'AI', 'SaaS', 'Blockchain', 'E-commerce', 'ClimateTech'
        ];

        $stages = [
            'Pre-Seed', 'Seed', 'Series A', 'Series B', 'Growth', 'Late Stage'
        ];

        foreach ($verticals as $name) {
            Tag::updateOrCreate([
                'name' => $name,
                'type' => 'vertical'
            ]);
        }

        foreach ($stages as $name) {
            Tag::updateOrCreate([
                'name' => $name,
                'type' => 'stage'
            ]);
        }
    }
}
