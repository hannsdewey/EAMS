<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->integer('total_present')->default(0);
            $table->integer('total_absent')->default(0);
            $table->integer('total_late')->default(0);
            $table->integer('total_leave')->default(0);
            $table->decimal('total_work_hours', 8, 2)->default(0);
            $table->decimal('total_overtime_hours', 8, 2)->default(0);
            $table->integer('active_shifts')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'report_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}; 