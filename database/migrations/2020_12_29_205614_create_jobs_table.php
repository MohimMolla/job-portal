<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('jobs', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->foreignId('category_id')->constrained()->cascadeOnDelete();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->enum('type', [1, 2, 3, 4, 5]);
      $table->foreignId('city_id')->constrained()->cascadeOnDelete();
      $table->text('description');
      $table->date('deadline')->nullable();
      $table->longText('hiring');
      $table->double('monthly_salary_min')->default('0.00');
      $table->double('monthly_salary_max')->default('0.00');
      $table->boolean('status')->default(1);
      $table->integer('year_passing_from')->nullable();
      $table->integer('year_passing_to')->nullable();
      $table->integer('experience_from')->nullable();
      $table->integer('experience_to')->nullable();
      $table->enum('gender', [1, 2, 3])->default(3);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('jobs');
  }
}
