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
        Schema::create('module_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('notification_email')->nullable();
            $table->integer('max_submissions')->default(0);
            $table->integer('max_submissions_per_user')->default(0);
            $table->boolean('recaptcha')->default(false);
            $table->boolean('guest')->default(false);
            $table->boolean('can_view_submission')->default(true);
            $table->boolean('can_respond')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('module_forms_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('placeholder')->nullable();
            $table->string('default_value')->nullable();
            $table->string('name');
            $table->string('rules')->nullable();
            $table->integer('order')->default(0);
            $table->json('options')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('module_forms')->onDelete('cascade');

            // make sure name and form_id are unique
            $table->unique(['name', 'form_id']);
        });

        Schema::create('module_forms_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('module_forms_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('ip_address');
            $table->text('user_agent');
            $table->json('data');
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('module_forms')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('module_forms_statuses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_forms');
        Schema::dropIfExists('module_forms_fields');
        Schema::dropIfExists('module_forms_statuses');
        Schema::dropIfExists('module_forms_submissions');
    }
};
