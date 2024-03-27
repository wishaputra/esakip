<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // The name of the node.
            $table->unsignedBigInteger('parent_id')->nullable(); // Self-referencing parent ID.
            $table->integer('order')->default(0); // For ordering nodes under the same parent.
            $table->timestamps();

            // Optional: Specify a foreign key constraint for parent_id.
            $table->foreign('parent_id')
                  ->references('id')->on('trees')
                  ->onDelete('cascade'); // If a parent is deleted, delete its children as well.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('trees');
    }
}
