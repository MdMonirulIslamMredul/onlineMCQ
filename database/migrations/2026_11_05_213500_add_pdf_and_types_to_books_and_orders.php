<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfAndTypesToBooksAndOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'pdf_file')) {
                $table->string('pdf_file')->nullable()->after('image');
            }
            if (!Schema::hasColumn('books', 'book_type')) {
                $table->string('book_type')->default('both')->after('pdf_file'); // 'both', 'hardcopy', 'softcopy'
            }
            if (!Schema::hasColumn('books', 'hardcopy_price')) {
                $table->decimal('hardcopy_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('books', 'softcopy_price')) {
                $table->decimal('softcopy_price', 10, 2)->nullable()->after('hardcopy_price');
            }
        });

        Schema::table('books_order', function (Blueprint $table) {
            if (!Schema::hasColumn('books_order', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('pid');
            }
            if (!Schema::hasColumn('books_order', 'book_type')) {
                $table->string('book_type')->default('hardcopy')->after('user_id'); // 'hardcopy', 'softcopy'
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'softcopy_price')) {
                $table->dropColumn('softcopy_price');
            }
            if (Schema::hasColumn('books', 'hardcopy_price')) {
                $table->dropColumn('hardcopy_price');
            }
            if (Schema::hasColumn('books', 'book_type')) {
                $table->dropColumn('book_type');
            }
            if (Schema::hasColumn('books', 'pdf_file')) {
                $table->dropColumn('pdf_file');
            }
        });

        Schema::table('books_order', function (Blueprint $table) {
            if (Schema::hasColumn('books_order', 'book_type')) {
                $table->dropColumn('book_type');
            }
            if (Schema::hasColumn('books_order', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}

