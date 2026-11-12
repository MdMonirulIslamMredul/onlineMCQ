<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManualPaymentFieldsToBooksOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books_order', function (Blueprint $table) {
            if (!Schema::hasColumn('books_order', 'payment_gateway_id')) {
                $table->unsignedBigInteger('payment_gateway_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('books_order', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_gateway_id');
            }
            if (!Schema::hasColumn('books_order', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('books_order', 'sender_number')) {
                $table->string('sender_number')->nullable()->after('payment_type');
            }
            if (!Schema::hasColumn('books_order', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('sender_number');
            }
            if (!Schema::hasColumn('books_order', 'bank_account_number')) {
                $table->string('bank_account_number')->nullable()->after('bank_name');
            }
            if (!Schema::hasColumn('books_order', 'trx_id')) {
                $table->string('trx_id')->nullable()->after('bank_account_number');
            }
            if (!Schema::hasColumn('books_order', 'screenshot')) {
                $table->string('screenshot')->nullable()->after('trx_id');
            }
            if (!Schema::hasColumn('books_order', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('screenshot');
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
        Schema::table('books_order', function (Blueprint $table) {
            $cols = [
                'payment_gateway_id',
                'payment_method',
                'payment_type',
                'sender_number',
                'bank_name',
                'bank_account_number',
                'trx_id',
                'screenshot',
                'admin_note'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('books_order', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}

