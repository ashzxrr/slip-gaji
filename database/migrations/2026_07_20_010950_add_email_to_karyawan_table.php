<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('karyawan', 'email')) {
            Schema::table('karyawan', function (Blueprint $table) {
                $table->string('email')->nullable()->after('no_whatsapp');
            });
        }

        if (!Schema::hasColumn('karyawan', 'email')) {
            return;
        }

        $connection = Schema::getConnection();
        $indexes = $connection->select("PRAGMA index_list('karyawan')");
        $hasIndex = collect($indexes)->contains(fn ($index) => ($index->name ?? '') === 'karyawan_email_unique');

        if (!$hasIndex) {
            $connection->statement('CREATE UNIQUE INDEX karyawan_email_unique ON karyawan (email)');
        }
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};
