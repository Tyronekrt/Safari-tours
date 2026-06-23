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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('package_id')->nullable()->constrained('safari_packages')->onDelete('set null');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->date('travel_date')->nullable();
            $table->integer('duration')->nullable();
            $table->string('budget')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'quotation_sent', 'negotiation', 'confirmed', 'cancelled'])->default('new');
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'created_at']);
            $table->index('assigned_to');
            $table->index('package_id');
            $table->index('travel_date');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
