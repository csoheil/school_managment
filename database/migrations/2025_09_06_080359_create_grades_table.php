<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::create('grades', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('user_id'); // Student
$table->unsignedBigInteger('subject_id');
$table->float('score'); // Grade score (e.g., 85.5)
$table->text('comments')->nullable();
$table->timestamps();
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
});
}

public function down(): void {
Schema::dropIfExists('grades');
}
};
