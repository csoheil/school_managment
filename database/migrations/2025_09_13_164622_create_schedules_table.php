<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void {
Schema::create('schedules', function (Blueprint $table) {
$table->id();
$table->unsignedBigInteger('class_id');
$table->unsignedBigInteger('subject_id');
$table->string('day_of_week'); // e.g., Monday
$table->time('start_time');
$table->time('end_time');
$table->timestamps();
$table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
});
}

public function down(): void {
Schema::dropIfExists('schedules');
}
};
