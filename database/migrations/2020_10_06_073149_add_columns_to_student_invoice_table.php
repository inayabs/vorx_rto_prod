<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStudentInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasColumn('student_invoice', 'transaction_number')) {
            Schema::table('student_invoice', function (Blueprint $table) {
                $table->string('transaction_number', 50)->change()->nullable();
            });
        }
        if (!Schema::hasColumn('student_invoice', 'payment_schedule_template_id')) {
            Schema::table('student_invoice', function (Blueprint $table) {
                $table->integer('payment_schedule_template_id')->after('student_id')->nullable();
            });
        }
        if (!Schema::hasColumn('student_invoice', 'description')) {
            Schema::table('student_invoice', function (Blueprint $table) {
                $table->string('description', 191)->after('amount')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_invoice', function (Blueprint $table) {
            $table->dropColumn(['payment_schedule_template_id','description']);
        });
    }
}
