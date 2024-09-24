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
        Schema::create('userbalance', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0)->comment('User ID');
            $table->integer('refer_id')->default(0)->comment('Refered User ID');
            $table->decimal('deposit', 15, 2)->default(0.00)->comment('User salary');
            $table->decimal('bonus', 15, 2)->default(0.00)->comment('User salary');
            $table->decimal('winning', 15, 2)->default(0.00)->comment('User salary');
            $table->decimal('affilate_commision', 15, 2)->default(0.00)->comment('User salary');
            $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userbalance');
    }
};
