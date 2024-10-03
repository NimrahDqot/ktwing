<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleSubmoduleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('module_submodule_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->default(null); // Adjust if your module table is different
            $table->foreignId('sub_module_id')->default(null); // Adjust if your submodule table is different
            $table->foreignId('role_id')->default(null); // Assuming there's a roles table
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
        Schema::dropIfExists('module_submodule_roles');
    }
}
