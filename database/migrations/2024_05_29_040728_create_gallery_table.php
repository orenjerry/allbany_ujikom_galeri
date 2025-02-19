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
        Schema::create('allbany_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_code');
            $table->string('role_name');
            $table->timestamps();
        });
        Schema::create('allbany_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_role')->unsigned();
            $table->foreign('id_role')->references('id')->on('allbany_role')->onDelete('cascade');
            $table->string('foto_profil')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->enum('accepted', ['1', '0', 'rejected'])->default('0');
            $table->timestamps();
        });
        Schema::create('allbany_album', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('allbany_user')->onDelete('cascade');
            $table->string('nama_album');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
        Schema::create('allbany_foto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('allbany_user')->onDelete('cascade');
            $table->bigInteger('id_album')->unsigned();
            $table->foreign('id_album')->references('id')->on('allbany_album')->onDelete('cascade');
            $table->string('lokasi_file');
            $table->string('judul_foto');
            $table->string('deskripsi_foto')->nullable();
            $table->timestamps();
        });
        Schema::create('allbany_foto_komentar', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->bigInteger('id_foto')->unsigned();
            $table->foreign('id_foto')->references('id')->on('allbany_foto')->onDelete('cascade');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('allbany_user')->onDelete('cascade');
            $table->string('isi_komentar');
            $table->timestamps();
        });
        Schema::create('allbany_foto_like', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_foto')->unsigned();
            $table->foreign('id_foto')->references('id')->on('allbany_foto')->onDelete('cascade');
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('allbany_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allbany_role');
        Schema::dropIfExists('allbany_user');
        Schema::dropIfExists('allbany_album');
        Schema::dropIfExists('allbany_foto');
        Schema::dropIfExists('allbany_foto_komentar');
        Schema::dropIfExists('allbany_foto_like');
    }
};
