<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->foreignId('pump_id')
                ->after('customer_vehicle_id') // kolom muncul setelah "status"
                ->nullable()
                ->constrained('pumps')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropForeign(['pump_id']);
            $table->dropColumn('pump_id');
        });
    }
};
