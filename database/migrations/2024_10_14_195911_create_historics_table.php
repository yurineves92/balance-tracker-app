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
        Schema::create('historics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['I', 'O', 'T']); // I = Incoming, O = Outgoing, T = Transfer
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('total_before', 10, 2)->default(0);
            $table->decimal('total_after', 10, 2)->default(0);
            $table->integer('user_id_transaction')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historics');
    }
};
