<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Program;
use Illuminate\Support\Str;

class SalamaSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent — safe to run on every deploy
        Facility::updateOrCreate(
            ['slug' => 'salama-childrens-home'],
            [
                'name' => "Salama Children's Home (SOVc)",
                'type' => 'childrens_home',
                'description' => "Salama Children's Home was founded by Mr. Muhammad Mwiga on 7 January 2023. We provide care, protection, education and skills development for orphans and vulnerable children in Bagamoyo (Pwani) and surrounding areas through kindergarten, mechanics and tailoring programmes.",
                'region' => 'Coast',
                'district' => 'Bagamoyo',
                'address' => 'Kiharaka, Bagamoyo, Tanzania',
                'latitude' => -6.4455,
                'longitude' => 38.9012,
                'phone' => '+255 688 489 495',
                'email' => 'info@salamachildrens.or.tz',
                'website' => 'https://salamachildrens.or.tz',
                'services' => ['kindergarten', 'mechanics training', 'tailoring', 'shelter', 'vocational education'],
                'status' => 'active',
                'verified_at' => now(),
                'next_review_at' => now()->addYear(),
                'verification_source' => 'Organisation self-declaration',
                'is_salama_owned' => true,
            ]
        );

        $programs = [
            [
                'title' => 'Kindergarten Programme',
                'image' => 'images/programs/kindergarten.jpg',
                'category' => 'kindergarten',
                'description' => "The Kindergarten programme provides accessible preschool education to toddlers from low-income and underserved communities in Bagamoyo.\n\nChildren aged 3–6 engage in play-based learning, basic literacy and numeracy, arts and crafts, social skills, music and physical play in a safe and nurturing environment.\n\nThe programme includes nutritious snacks and health monitoring to support holistic development and school readiness.",
                'eligibility' => 'Children aged 3–6 years from vulnerable households in Bagamoyo area.',
                'location' => "Salama Children's Home, Bagamoyo",
                'is_open_for_registration' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Motorcycle Mechanics Training',
                'image' => 'images/programs/mechanics.jpg',
                'category' => 'mechanics',
                'description' => "Hands-on vocational training in motorcycle repair and maintenance. Participants learn engine diagnostics, brake systems, electrical troubleshooting, tyre and chain maintenance, and general servicing.\n\nThe programme combines practical workshops with mentorship and aims to help graduates start small repair businesses or secure employment in a high-demand trade.",
                'eligibility' => 'Older children and youth from vulnerable backgrounds seeking practical skills.',
                'location' => "Salama Children's Home workshop, Bagamoyo",
                'is_open_for_registration' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Tailoring & Sewing Skills',
                'image' => 'images/programs/tailoring.jpg',
                'category' => 'tailoring',
                'description' => "Vocational training in sewing and garment-making. Participants learn pattern making, garment construction, machine operation, alterations and basic design principles.\n\nGraduates receive certification and support toward launching small tailoring businesses or finding employment in the local textile sector.",
                'eligibility' => 'Youth from disadvantaged communities interested in garment skills.',
                'location' => "Salama Children's Home, Bagamoyo",
                'is_open_for_registration' => true,
                'status' => 'published',
            ],
        ];

        foreach ($programs as $data) {
            Program::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                $data
            );
        }
    }
}
