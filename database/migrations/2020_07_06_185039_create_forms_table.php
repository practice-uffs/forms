<?php

use App\Model\Form;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');
            $table->boolean('is_accepting_replies')->index()->default(true);
            $table->boolean('is_auth_required')->index()->default(false);
            $table->boolean('is_one_reply_only')->index()->default(false);
            $table->boolean('timer')->default(false);
            
            $table->date('date_to_answer')->nullable();
            $table->time('time_to_answer')->nullable();

            $table->string('title');
            $table->text('user_questions')->default('');
            $table->text('questions');
            $table->string('hash');
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
        Schema::dropIfExists('forms');
    }
}
