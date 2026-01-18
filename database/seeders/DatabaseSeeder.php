public function run(): void
{
    $this->call([
        UserSeeder::class,
        StudentSeeder::class,
        CourseSeeder::class,
    ]);
}