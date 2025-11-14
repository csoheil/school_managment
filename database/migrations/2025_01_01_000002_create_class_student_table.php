<?php

Schema::create('class_student', function (Blueprint $table) {
$table->foreignId('class_id')->constrained()->cascadeOnDelete();
$table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
$table->primary(['class_id', 'student_id']);
});
