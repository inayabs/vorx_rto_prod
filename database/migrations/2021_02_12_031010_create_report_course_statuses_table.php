<?php

use App\Models\ReportCourseStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCourseStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('report_course_statuses')) {
            Schema::create('report_course_statuses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('status', 50);
                $table->timestamps();
                $table->softDeletes();
            });

            $d = new ReportCourseStatuses([
                'status' => 'Do not report',
            ]);
            $d->save();
            $d = new ReportCourseStatuses([
                'status' => 'Report',
            ]);
            $d->save();
            $d = new ReportCourseStatuses([
                'status' => 'Claimed',
            ]);
            $d->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_course_statuses');
    }
}
