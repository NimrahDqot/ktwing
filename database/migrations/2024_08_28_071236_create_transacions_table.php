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
        Schema::create('transacions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0)->comment('User ID');
            $table->integer('refer_id')->default(0)->comment('Refered User ID');
            $table->string('type')->nullable()->comment('Deposit Amount, Game Joined Amount , Game Join Refund , Game Winning Amount , Withdraw Amount , etc');
            $table->string('transaction_id')->nullable();
            $table->string('transaction_by')->nullable();
            $table->string('paymentstatus')->nullable()->comment('Pending, Processing , confirmed , Rejected ,etc');
            $table->integer('game_joined_id')->default(0)->comment('Game Join ID');
            $table->decimal('amount', 15, 2)->default(0.00);
            $table->decimal('service_charge_amount', 15, 2)->default(0.00);
            $table->decimal('gst_amount', 15, 2)->default(0.00);
            $table->decimal('tds_amount', 15, 2)->default(0.00);
            $table->decimal('deposit_amt', 15, 2)->default(0.00);
            $table->decimal('bonus_amt', 15, 2)->default(0.00);
            $table->decimal('winning_amt', 15, 2)->default(0.00);
            $table->decimal('bal_deposit_amt', 15, 2)->default(0.00);
            $table->decimal('bal_bonus_amt', 15, 2)->default(0.00);
            $table->decimal('bal_winning_amt', 15, 2)->default(0.00);
            $table->decimal('total_available_balance', 15, 2)->default(0.00)->comment('Total Wallets');
            $table->decimal('cons_deposit', 15, 2)->default(0.00);
            $table->decimal('cons_winning', 15, 2)->default(0.00);
            $table->decimal('cons_bonus', 15, 2)->default(0.00);
            $table->index('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacions');
    }
};
