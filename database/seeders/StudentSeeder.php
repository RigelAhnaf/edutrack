<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['nim' => '2021001', 'name' => 'John Doe', 'email' => 'john@student.com', 'phone' => '081234567890'],
            ['nim' => '2021002', 'name' => 'Jane Smith', 'email' => 'jane@student.com', 'phone' => '081234567891'],
            ['nim' => '2021003', 'name' => 'Bob Johnson', 'email' => 'bob@student.com', 'phone' => '081234567892'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}