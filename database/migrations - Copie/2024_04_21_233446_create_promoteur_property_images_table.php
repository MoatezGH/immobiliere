<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promoteur_property_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("property_id")->unsigned();
            $table->string("title");
            $table->integer("is_main")->default(0);
            $table->tinyInteger("is_main_picture")->default(0);
            $table->foreign('property_id')->references('id')->on('promoteur_properties');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoteur_property_images');
    }
};
