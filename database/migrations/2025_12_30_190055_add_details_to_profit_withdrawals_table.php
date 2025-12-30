<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profit_withdrawals', function (Blueprint $table) {
            $table->string('network')->nullable()->after('amount');
            $table->string('wallet_address')->nullable()->after('network');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profit_withdrawals', function (Blueprint $table) {
            $table->dropColumn(['network', 'wallet_address']);
        });
    }
};
