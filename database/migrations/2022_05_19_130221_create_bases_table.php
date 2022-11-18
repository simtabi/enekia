<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('domain')->unique();
            $table->boolean('mx');
            $table->boolean('disposable');
            $table->integer('hits')->default(1);
            $table->timestamp('last_queried');
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
        Schema::drop($this->getTableName());
    }

    private function getTableName(): string
    {
        return config('disposable.domain.checks_table');
    }
};
