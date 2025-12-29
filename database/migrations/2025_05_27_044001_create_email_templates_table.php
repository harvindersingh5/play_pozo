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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Unique identifier for the email template (e.g., registration_confirmation)');
            $table->string('subject')->comment('The subject line of the email');
            $table->longText('body')->comment('The HTML content of the email body');
            $table->text('description')->nullable()->comment('A brief description for internal admin use')->limit(1000);
            $table->text('variables')->nullable()->comment('JSON or comma-separated list of expected variables (e.g., {{user_name}}, {{reset_link}})');
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
