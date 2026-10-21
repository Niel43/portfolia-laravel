<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->string('public_id', 64)->nullable()->unique();
        });

        // Give existing portfolios a shareable URL too, not only newly created ones.
        DB::table('portfolios')->whereNull('public_id')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                do {
                    $publicId = Str::random(32);
                } while (DB::table('portfolios')->where('public_id', $publicId)->exists());

                DB::table('portfolios')->where('id', $row->id)->update(['public_id' => $publicId]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropUnique(['public_id']);
            $table->dropColumn('public_id');
        });
    }
};
