<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{Student, User};
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_view_students_list()
    {
        $this->actingAs($this->user)
            ->get(route('students.index'))
            ->assertStatus(200)
            ->assertViewIs('students.index');
    }

    public function test_can_create_student()
    {
        $studentData = [
            'nim' => '12345678',
            'name' => 'Test Student',
            'email' => 'test@example.com'
        ];

        $this->actingAs($this->user)
            ->post(route('students.store'), $studentData)
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'nim' => '12345678'
        ]);
    }
}