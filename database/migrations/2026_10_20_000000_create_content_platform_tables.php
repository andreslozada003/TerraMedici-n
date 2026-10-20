<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::table('users', function(Blueprint $t){ $t->boolean('is_admin')->default(false)->index(); });
  Schema::create('contents', function(Blueprint $t){ $t->id(); $t->enum('type',['service','project','post'])->index(); $t->string('title'); $t->string('slug')->unique(); $t->text('excerpt')->nullable(); $t->longText('body')->nullable(); $t->string('location')->nullable(); $t->string('category')->nullable()->index(); $t->string('cover_path')->nullable(); $t->enum('status',['draft','published','archived'])->default('draft')->index(); $t->timestamp('published_at')->nullable()->index(); $t->string('meta_description',160)->nullable(); $t->timestamps(); $t->softDeletes(); });
  Schema::create('contact_messages', function(Blueprint $t){ $t->id(); $t->string('name'); $t->string('email'); $t->string('phone',30)->nullable(); $t->text('message'); $t->timestamps(); });
  Schema::create('activity_logs', function(Blueprint $t){ $t->id(); $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); $t->string('action'); $t->morphs('subject'); $t->json('properties')->nullable(); $t->timestamps(); });
 }
 public function down(): void { Schema::dropIfExists('activity_logs'); Schema::dropIfExists('contact_messages'); Schema::dropIfExists('contents'); Schema::table('users', fn(Blueprint $t)=>$t->dropColumn('is_admin')); }
};
