<?php

declare(strict_types=1);

use App\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_user_pages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('social_user_id')->references('id')->on('social_users')->cascadeOnDelete();
            $table->string('page_id')->nullable();
            $table->string('name')->nullable();
            $table->string('access_token', 512)->nullable();
            $table->string('category')->nullable();
            $table->string('medium');
            $table->string('status')->default(Status::ACTIVE);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_user_pages');
    }
};
