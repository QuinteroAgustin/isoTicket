<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('infos_utiles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('description');
            $table->text('icon')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('ordre')->default(0);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });

        // Modification des colonnes pour SQL Server
        DB::statement('ALTER TABLE infos_utiles ALTER COLUMN created_at datetime2');
        DB::statement('ALTER TABLE infos_utiles ALTER COLUMN updated_at datetime2');
    }

    public function down()
    {
        Schema::dropIfExists('infos_utiles');
    }
};