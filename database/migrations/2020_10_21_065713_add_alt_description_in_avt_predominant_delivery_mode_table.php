<?php

use App\Models\AvtPredominantDlvrMode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAltDescriptionInAvtPredominantDeliveryModeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('avt_predominant_delivery_mode', 'alt_description')) {
            Schema::table('avt_predominant_delivery_mode', function (Blueprint $table) {
                $table->string('alt_description', '255')->nullable();
            });

            if (!Schema::hasColumn('avt_predominant_delivery_mode', 'created_at')) {
                Schema::table('avt_predominant_delivery_mode', function (Blueprint $table) {
                    $table->timestamps();
                });
            }

            $d = AvtPredominantDlvrMode::where('value', 'I')->first();
            $d->alt_description = 'Face to face';
            $d->update();
            $d = AvtPredominantDlvrMode::where('value', 'E')->first();
            $d->alt_description = 'Distance Learning';
            $d->update();
            $d = AvtPredominantDlvrMode::where('value', 'W')->first();
            $d->alt_description = 'Work based';
            $d->update();
            $d = AvtPredominantDlvrMode::where('value', 'N')->first();
            $d->alt_description = 'Not applicable – recognition of prior learning/credit transfer';
            $d->update();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('avt_predominant_delivery_mode', 'alt_description')) {
            Schema::table('avt_predominant_delivery_mode', function (Blueprint $table) {
                $table->dropColumn(['alt_description']);
            });
        }
    }
}
