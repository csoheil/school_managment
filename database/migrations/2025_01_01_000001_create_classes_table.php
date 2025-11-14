<?php

Schema::create('classes', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->text('description')->nullable();
$table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
$table->integer('grade_level');
$table->timestamps();
});
