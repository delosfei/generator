<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('id', true, true)->comment('ID');
            $table->string('mobile', 15)->nullable()->unique()->comment('手机号');
            $table->string('name', 30)->nullable()->comment('昵称');
            $table->string('email', 50)->nullable()->unique()->comment('邮箱');
            $table->string('real_name', 20)->nullable()->comment('真实姓名');
            $table->string('password', 255)->nullable()->comment('密码');
            $table->string('home', 255)->nullable()->comment('网站');
            $table->string('avatar', 255)->nullable()->comment('头像');
            $table->string('wechat', 255)->nullable()->comment('微信号');
            $table->bigInteger('group_id', false)->default('1')->comment('默认系统会员组');
            $table->datetime('email_verified_at')->nullable()->comment('邮箱验证时间');
            $table->datetime('mobile_verified_at')->nullable()->comment('手机验证时间');
            $table->integer('favour_count', false, true)->comment('点赞数');
            $table->integer('favorite_count', false, true)->comment('收藏数');
            $table->string('remember_token', 100)->comment('记住我');
            $table->boolean('lock')->nullable()->comment('用户锁定');
            $table->integer('ren', false, true)->default('1')->comment('仁');
            $table->integer('yi', false, true)->default('1')->comment('义');
            $table->integer('li', false, true)->default('1')->comment('礼');
            $table->integer('zhi', false, true)->default('1')->comment('智');
            $table->integer('xin', false, true)->default('1')->comment('信');
            $table->integer('score', false, true)->default('1')->comment('综合得分');
            $table->boolean('is_super_admin')->nullable()->comment('超级管理员');
            $table->bigInteger('current_team_id', false, true)->comment('当前队id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
