<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::create('subjects', function (Blueprint $table) {
$table->id();
$table->string('name'); // Subject name, e.g., "Math"
$table->string('code')->unique(); // e.g., "MATH101"
$table->unsignedBigInteger('teacher_id')->nullable();
$table->timestamps();
$table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
});
}

public function down(): void {
Schema::dropIfExists('subjects');
}
};
