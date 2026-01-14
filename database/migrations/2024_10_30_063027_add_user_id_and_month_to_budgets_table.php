<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Check if columns already exist (in case migration was partially run)
        $hasUserId = Schema::hasColumn('budgets', 'user_id');
        $hasMonth = Schema::hasColumn('budgets', 'month');
        $hasYear = Schema::hasColumn('budgets', 'year');
        
        // Step 1: Add columns as nullable first (only if they don't exist)
        if (!$hasUserId || !$hasMonth || !$hasYear) {
            Schema::table('budgets', function (Blueprint $table) use ($hasUserId, $hasMonth, $hasYear) {
                if (!$hasUserId) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('id');
                }
                if (!$hasMonth) {
                    $table->string('month')->nullable()->after($hasUserId ? 'user_id' : 'id');
                }
                if (!$hasYear) {
                    $table->string('year')->nullable()->after($hasMonth ? 'month' : ($hasUserId ? 'user_id' : 'id'));
                }
            });
        }
        
        // Step 2: Clean up existing data - delete rows with invalid or null user_ids
        // Or assign them to the first user if you want to keep the data
        // For safety, we'll delete orphaned budget records
        if ($hasUserId) {
            // Get all valid user IDs
            $validUserIds = DB::table('users')->pluck('id')->toArray();
            
            // Delete budgets with null user_id or invalid user_id
            DB::table('budgets')
                ->where(function($query) use ($validUserIds) {
                    $query->whereNull('user_id')
                          ->orWhereNotIn('user_id', $validUserIds ?: [0]);
                })
                ->delete();
        }
        
        // Step 3: Make user_id not nullable (if you want to enforce it)
        // Only change if column exists and is currently nullable
        if ($hasUserId) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            });
        }
        if ($hasMonth) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->string('month')->nullable(false)->change();
            });
        }
        if ($hasYear) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->string('year')->nullable(false)->change();
            });
        }
        
        // Step 4: Check if foreign key already exists, then add it if it doesn't
        $dbName = DB::connection()->getDatabaseName();
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = 'budgets' 
            AND CONSTRAINT_NAME = 'budgets_user_id_foreign'
        ", [$dbName]);
        
        if (empty($foreignKeys) && $hasUserId) {
            // Before adding foreign key, ensure all user_ids are valid
            $validUserIds = DB::table('users')->pluck('id')->toArray();
            if (!empty($validUserIds)) {
                // Delete any remaining invalid records
                DB::table('budgets')
                    ->whereNotIn('user_id', $validUserIds)
                    ->orWhereNull('user_id')
                    ->delete();
                
                // Now add the foreign key
                Schema::table('budgets', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                });
            }
        }
    }

    public function down()
    {
        // Check if foreign key exists before dropping
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'budgets' 
            AND CONSTRAINT_NAME = 'budgets_user_id_foreign'
        ");
        
        if (!empty($foreignKeys)) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
        
        // Drop columns if they exist
        if (Schema::hasColumn('budgets', 'user_id')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }
        if (Schema::hasColumn('budgets', 'month')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('month');
            });
        }
        if (Schema::hasColumn('budgets', 'year')) {
            Schema::table('budgets', function (Blueprint $table) {
                $table->dropColumn('year');
            });
        }
    }
};
