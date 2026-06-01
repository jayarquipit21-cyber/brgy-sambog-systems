<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_closures', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('weekday')->comment('1=Mon .. 7=Sun');
            $table->boolean('closed')->default(false);
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        // Seed default weekend closures
        DB::table('appointment_closures')->insert([
            ['weekday' => 6, 'closed' => true, 'reason' => 'Weekend', 'created_at' => now(), 'updated_at' => now()],
            ['weekday' => 7, 'closed' => true, 'reason' => 'Weekend', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_closures');
    }
};
