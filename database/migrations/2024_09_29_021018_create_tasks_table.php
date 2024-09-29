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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->longText("description");
            $table->timestamp("deadline");
            $table->integer("status")->default(1);
            $table->integer("priority")->default(1);
            $table->foreignIdFor(User::class, "created_by")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignIdFor(User::class, "modified_by")->nullable()->constrained("users")->nullOnDelete();
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
        Schema::dropIfExists('tasks');
    }
};
