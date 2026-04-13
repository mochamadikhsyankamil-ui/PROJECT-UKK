<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('lendings', function (Blueprint $table) {

        // tanda tangan saat meminjam
        $table->longText('borrower_sign_1')->nullable();
        $table->longText('borrower_sign_2')->nullable();
        $table->longText('operator_sign_1')->nullable();
        $table->longText('operator_sign_2')->nullable();

        // tanda tangan saat mengembalikan
        $table->longText('return_borrower_sign_1')->nullable();
        $table->longText('return_borrower_sign_2')->nullable();
        $table->longText('return_operator_sign_1')->nullable();
        $table->longText('return_operator_sign_2')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lendings', function (Blueprint $table) {
            //
        });
    }
};
