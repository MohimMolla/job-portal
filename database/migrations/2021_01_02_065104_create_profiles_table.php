<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('jobrole')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->default('avatar.jpg');
            $table->string('cv')->nullable();
            $table->string('education')->nullable();
            $table->longText('location')->nullable();
            $table->longText('skills')->nullable();
            $table->enum('job_type', [1, 2, 3, 4, 5])->default(1);
            $table->text('about')->nullable();
            $table->integer('experience')->default(0);
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
        Schema::dropIfExists('profiles');
    }
}
