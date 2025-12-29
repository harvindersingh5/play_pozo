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
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('secret_key')->nullable();
            $table->text('public_key')->nullable();
            $table->string('account_holder_name', 100)->nullable();
            $table->date('account_holder_dob')->nullable();
            $table->enum('business_type', ['INDIVIDUAL', 'COMPANY'])->nullable();
            $table->enum('account_type', ['CUSTOM', 'EXPRESS', 'STANDARD'])->nullable();
            $table->string('account_number', 12)->nullable();
            $table->string('routing_number', 9)->nullable();
            $table->char('currency', 3)->default('usd')->nullable();
            $table->char('country', 2)->default('US')->nullable();
            $table->enum('is_verified',['YES', 'NO'])->nullable();
            $table->enum('transfer_to',['STRIPE', 'BANK'])->nullable();
            $table->string('stripe_btok_token', 100)->nullable();
            $table->string('stripe_ba_token', 100)->nullable();
            $table->string('stripe_account_token', 100)->nullable();
            $table->longText('stripe_btok_token_response')->nullable();
            $table->longText('stripe_account_token_response')->nullable();
            $table->text('paypal_client_id')->nullable();
            $table->text('paypal_client_secret')->nullable();
            $table->string('paypal_mode')->nullable()->comment('sandbox or live'); 
            $table->boolean('is_stripe_active')->default(false);
            $table->boolean('is_paypal_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
