
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('emp_id');
            $table->String('fname');
            $table->String('lname');
            $table->String('phone');
            $table->String('email');
            $table->String('gender');
            $table->Text('address');
            $table->String('salary');
            $table->unsignedBigInteger('dep_id');
            $table->foreign('dep_id')->references('dep_id')->on('departments');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
