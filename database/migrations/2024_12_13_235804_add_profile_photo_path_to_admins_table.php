?<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePhotoPathToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'profile_photo_path')) {
                $table->text('profile_photo_path')->nullable()->after('current_team_id');
            }
        });
    }
    
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'profile_photo_path')) {
                $table->dropColumn('profile_photo_path');
            }
        });
    }
    
}
