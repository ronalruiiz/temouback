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
        Schema::create('therapies', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->boolean('visibility')->default(false);
            $table->string("type");
            $table->string('link')->default("");
            $table->foreignId("user_id")->onDelete('cascade');
            $table->date("expiration");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapies');
    }
};
