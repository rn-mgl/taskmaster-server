<?php

use App\Models\Project;
use App\Models\User;
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
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->longText("message");
            $table->foreignIdFor(User::class, "sender_id")->constrained("users")->cascadeOnDelete();
            $table->foreignIdFor(User::class, "receiver_id")->constrained("users")->cascadeOnDelete();
            $table->foreignIdFor(Project::class, "project_id")->constrained("projects")->cascadeOnDelete();
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
