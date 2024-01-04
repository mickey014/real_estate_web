<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('property_type');
            $table->string('property_status');
            $table->integer('is_featured');
            $table->integer('is_sold')->nullable();
            $table->integer('is_rent_paid')->nullable();
            $table->string('property_name');
            $table->string('property_name_slug');
            $table->string('property_desc');
            $table->integer('property_floors');
            $table->string('floor_plan1')->nullable();
            $table->string('floor_plan2')->nullable();
            $table->string('floor_plan3')->nullable();
            $table->integer('property_bed');
            $table->integer('property_bath');
            $table->integer('property_rooms');
            $table->integer('property_garages');
            $table->integer('property_area');
            $table->integer('property_size');
            $table->bigInteger('property_before_price');
            $table->bigInteger('property_after_price');
            $table->string('property_year_built')->default('Y-m-d');
            $table->integer('aircon');
            $table->integer('emergency_exit');
            $table->integer('fully_furnished');
            $table->integer('semi_furnished');
            $table->integer('gym');
            $table->integer('kitchen');
            $table->integer('laundry_room');
            $table->integer('lawn');
            $table->integer('meeting_rooms');
            $table->integer('onsite_parking');
            $table->integer('shared_iternet');
            $table->string('featured_img');
            $table->string('gallery_img1');
            $table->string('gallery_img2');
            $table->string('gallery_img3');
            $table->string('gallery_img4');
            $table->string('provinces');
            $table->string('barangays');
            $table->string('cities');
            $table->string('postal_code');
            $table->string('street_address');
            $table->string('street_address_slug');
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
        Schema::dropIfExists('property');
    }
};
