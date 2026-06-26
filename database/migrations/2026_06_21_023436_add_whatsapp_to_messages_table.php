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
    Schema::table('messages', function (Blueprint $table) {
        $table->string('whatsapp')->after('name');
        $table->string('email')->nullable()->change(); // Mengubah email jadi opsional
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('whatsapp');
        $table->string('email')->nullable(false)->change();
    });
}

};
