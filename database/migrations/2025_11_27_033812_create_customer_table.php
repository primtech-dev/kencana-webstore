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

        Schema::create('customer', function (Blueprint $table) {
            
            $table->id();
            $table->uuid('public_id')->unique()->comment('user uuid publik');
            $table->text('email')->unique()->comment('Email (login)');

            $table->string('google_id')->nullable()->after('email');

            $table->text('phone')->nullable()->comment('Nomor telepon');
            $table->text('full_name')->comment('Nama lengkap');

            $table->text('password_hash')->comment('Hash password');

            $table->text('token')->nullable()->comment('token sementara / reset (opsional)');

            $table->timestamp('expired_at')->nullable()->comment('waktu token expired');

            $table->boolean('is_active')->default(true)->comment('Aktif / non-aktif');

            $table->jsonb('meta')->nullable()->comment('Data tambahan (preferences, dsb)');


            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
