<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Enums\SocialType;
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
        Schema::create('social_users', function (Blueprint $table): void {
            $table->id();
            $table->string('social_id');
            $table->string('nickname')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('medium')->nullable();
            $table->string('profile_url')->nullable();
            $table->string('token', 512)->nullable();
            $table->string('refresh_token', 512)->nullable();
            $table->timestamp('expires_in')->nullable();
            $table->string('status')->default(Status::ACTIVE);
            $table->string('social_type')->default(SocialType::FACEBOOK);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_users');
    }
};
