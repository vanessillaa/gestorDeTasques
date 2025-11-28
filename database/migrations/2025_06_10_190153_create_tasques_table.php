<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasques', function (Blueprint $table) {
            $table->id();
            $table->string('titol')->unique();
            $table->text('descripcio');
            $table->date('data_limit');
            $table->string('estat');
            $table->timestamps();
        });

        // Schema::create('tasques', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('titol')->unique();
        //     $table->text('descripcio');
        //     $table->date('data_limit');
        //     $table->enum('estat', ['pendent', 'en_curs', 'completada'])->default('pendent');
        //     $table->timestamps();
        // });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasques');
    }
};
