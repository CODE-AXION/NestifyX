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
        $tableName = config('nestifyx.tables.name') ?? 'categories';
        

        if (empty($tableName)) {
            throw new \Exception('Error: config/nestifyx.php not loaded. Run [php artisan config:clear] and try again.');
        }
   


        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use($tableName) {
                // Check if 'position' column exists, if not add it
                if (!Schema::hasColumn($tableName, 'position')) {
                    $table->integer('position')->default(0);
                }


                // Check if 'deleted_at' column exists, if not add soft deletes
                if (!Schema::hasColumn($tableName, 'deleted_at')) {
                    $table->softDeletes();
                } 

                // Check if 'deleted_at' column exists, if not add soft deletes
                if (!Schema::hasColumn($tableName, 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->index();
                } 
            });
        } else {
            // Create the specified table
            Schema::create($tableName, function (Blueprint $table) use($tableName) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->unsignedBigInteger('parent_id')->nullable()->index();
                $table->boolean('status')->default(true);
                $table->integer('position')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($tableName, function (Blueprint $table) use($tableName) {
            //
        });
    }
};
