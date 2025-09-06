<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::create('classes', function (Blueprint $table) {
$table->id();
$table->string('name'); // Class name, e.g., "10A"
$table->text('description')->nullable();
$table->unsignedBigInteger('teacher_id')->nullable(); // Teacher assigned to class
$table->timestamps();
$table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
});
}

public function down(): void {
Schema::dropIfExists('classes');
}
};
