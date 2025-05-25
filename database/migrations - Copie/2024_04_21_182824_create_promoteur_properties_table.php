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
        Schema::create('promoteur_properties', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug");

            $table->bigInteger("operation_id")->unsigned();
            $table->bigInteger("category_id")->unsigned();
            $table->string("remise_des_clés");

            $table->string("ref");
            $table->tinyInteger("active")->default(0);


            $table->integer("price_total");
            $table->integer("price_metre")->nullable();
            $table->integer("price_metre_terrasse")->nullable();
            $table->integer("price_metre_jardin")->nullable();
            $table->integer("price_cellier")->nullable();
            $table->integer("price_parking")->nullable();

            $table->integer("surface_totale");
            $table->integer("surface_habitable")->nullable();
            $table->integer("surface_terrasse")->nullable();
            $table->integer("surface_jardin")->nullable();
            $table->integer("surface_cellier")->nullable();

            $table->bigInteger("city_id")->unsigned();
            $table->bigInteger("area_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();

            $table->string("address")->nullable();
            $table->text("description")->nullable();

            $table->integer("nb_bedroom")->default(0);
            $table->integer("nb_bathroom")->default(0);
            $table->integer("nb_kitchen")->default(0);
            $table->integer("nb_terrasse")->nullable();
            $table->integer("nb_etage")->nullable();
            $table->integer("nb_living")->nullable();


            $table->tinyInteger("balcon")->default(0);
            $table->tinyInteger("garden")->default(0);
            $table->tinyInteger("garage")->default(0);
            $table->tinyInteger("parking")->default(0);
            $table->tinyInteger("ascenseur")->default(0);
            $table->tinyInteger("heating")->default(0);
            $table->tinyInteger("climatisation")->default(0);
            $table->tinyInteger("system_alarm")->default(0);
            $table->tinyInteger("wifi")->default(0);
            $table->tinyInteger("piscine")->default(0);
            $table->integer("count_views")->default(0);
            // $table->bigInteger("is_main")->nullable();





            $table->foreign('operation_id')->references('id')->on('operations');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('user_id')->references('id')->on('users');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoteur_properties');
    }
};
