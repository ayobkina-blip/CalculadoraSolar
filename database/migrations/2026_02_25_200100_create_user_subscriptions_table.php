<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_fr');
            $table->unsignedBigInteger('plan_fr');
            $table->string('status', 20)->default('active'); // active, expired, cancelled
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedBigInteger('activated_by_fr')->nullable();
            $table->string('source', 40)->default('manual_admin');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('usuario_fr')
                ->references('id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('plan_fr')
                ->references('id')
                ->on('subscription_plans')
                ->onDelete('cascade');

            $table->foreign('activated_by_fr')
                ->references('id_usuario')
                ->on('usuarios')
                ->nullOnDelete();

            $table->index(['usuario_fr', 'status', 'ends_at']);
            $table->index(['status', 'starts_at', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
