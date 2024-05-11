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
        Schema::create('software_heritage_requests', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('saveRequestId');
            $table->string('originUrl');
            $table->enum('visitType', ['git', 'bzr', 'hg', 'svn']);
            $table->string('saveRequestDate')->default('SWH_save_request_date');
            $table->enum('saveRequestStatus', ['accepted', 'rejected', 'pending'])->default('pending');
            $table->enum('saveTaskStatus', ['not created', 'not yet scheduled', 'running', 'scheduled', 'succeeded', 'failed'])->default('not created');
            $table->enum('visitStatus', ['full', 'created', 'partial', 'not_found', 'failed' ])->nullable();
            $table->string('visitDate')->nullable();
            $table->bigInteger('loadingTaskId')->default(0);

            $table->json('swhIdList')->nullable();
            $table->json('contextualSwhIds')->nullable();
            $table->json('latexSnippets')->nullable();

            $table->boolean('isValid')->default(true);
            $table->boolean('hasConnectionError')->default(false);

            $table->unsignedBigInteger('createdBy_id')->nullable();
            $table->foreign('createdBy_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_heritage_requests');
    }
};
