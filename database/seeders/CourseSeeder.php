<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['code' => 'CS101', 'name' => 'Programming Basics', 'credits' => 3, 'semester' => 'Ganjil', 'description' => 'Learn basic programming'],
            ['code' => 'CS102', 'name' => 'Data Structures', 'credits' => 4, 'semester' => 'Genap', 'description' => 'Learn data structures'],
            ['code' => 'CS201', 'name' => 'Web Development', 'credits' => 3, 'semester' => 'Ganjil', 'description' => 'Learn web development'],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}