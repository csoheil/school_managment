
<?php

public function run()
{
$this->call([
RoleSeeder::class,
AdminSeeder::class,
TeacherSeeder::class,
StudentSeeder::class,
ClassSeeder::class,
]);
}
