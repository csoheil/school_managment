
<?php



public function test_student_cannot_access_admin_panel()
{
$student = User::factory()->create()->assignRole('student');
$response = $this->actingAs($student)->get('/admin/dashboard');
$response->assertStatus(403);
}
