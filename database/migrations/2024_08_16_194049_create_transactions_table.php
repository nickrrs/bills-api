<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->uuidMorphs('source');
            $table->string('transaction_type');
            $table->string('release_type');
            $table->foreignUuid('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignUuid('subcategory_id')->nullable()->constrained('subcategories')->cascadeOnDelete();
            $table->decimal('value');
            $table->boolean('hasPaid')->default(false);
            $table->boolean('hasReceived')->default(false);
            $table->timestamp('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
