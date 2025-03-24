<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('key', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->integer('created_by');
            $table->timestamps();
        });

        // Modification des colonnes pour SQL Server
        DB::statement('ALTER TABLE api_keys ALTER COLUMN created_at datetime2');
        DB::statement('ALTER TABLE api_keys ALTER COLUMN updated_at datetime2');
        DB::statement('ALTER TABLE api_keys ALTER COLUMN expires_at datetime2');
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};