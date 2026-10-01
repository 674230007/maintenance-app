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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // เชื่อมโยงกับตาราง users
            $table->string('title');               // หัวข้อการแจ้งซ่อม
            $table->text('description');           // รายละเอียดปัญหา
            $table->string('image')->nullable();   // รูปภาพหลักฐาน (รองรับกรณีไม่แนบรูป)
            $table->string('status')->default('pending'); // สถานะงาน (เริ่มต้นเป็น pending/รอดำเนินการ)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};