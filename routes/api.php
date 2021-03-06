<?php

use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', [
    'namespace' => 'App\Http\Controllers',
    'middleware' => []
], function ($api) {
    $api->group([], function ($api) {
        // 登录并获取 token
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 刷新 token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');

        // 删除 token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');

        // 获取首页
        $api->get('frontend/home', 'FrontendController@home')
            ->name('api.frontend.home');

        // 获取首页
        $api->get('about', 'FrontendController@about')
            ->name('api.frontend.about');

        // 获取分类列表
        $api->get('categories', 'CategoryController@get_list')
            ->name('api.categories.list');

        // 获取文章列表
        $api->get('post/list', 'PostController@get_list')
            ->name('api.post.list');

        // 获取文章
        $api->get('post', 'PostController@get')
            ->name('api.post.get');

        // reCAPTCHA 保护
        $api->group(['middleware' => 'recaptcha'], function ($api) {
            // 发表文章
            $api->post('post', 'PostController@store')
                ->name('api.recaptcha.post');

            // 发表评论
            $api->post('comment', 'CommentController@store')
                ->name('api.recaptcha.comment');

            // 举报
            $api->post('report', 'ReportController@store')
                ->name('api.recaptcha.report');

            $api->post('upload/img', 'UploadController@store')
                ->name('api.upload.img');

            // 点赞
            $api->post('favour/like', 'FavourController@like')
                ->name('api.favour.like');

            // 点踩
            $api->post('favour/dislike', 'FavourController@dislike')
                ->name('api.favour.dislike');
        });

        // 需要验证
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 获取设置
            $api->get('settings', 'SettingsController@get')
                ->name('api.auth.settings.get');

            // 保存设置
            $api->post('settings', 'SettingsController@store')
                ->name('api.auth.settings.post');

            // bot 发表文章
            $api->post('bot/post', 'PostController@store')
                ->name('api.auth.bot.post');

            // 添加用户
            $api->put('user', 'UserController@store')
                ->name('api.auth.add_user');

            // 删除用户
            $api->delete('user', 'UserController@destroy')
                ->name('api.auth.delete_user');

            // 获取用户列表
            $api->get('users', 'UserController@get_list')
                ->name('api.auth.get_users');

            // 获取用户信息
            $api->get('user', 'UserController@info')
                ->name('api.auth.info');

            // 修改用户信息
            $api->post('user', 'UserController@update')
                ->name('api.auth.update_user');

            // 删除文章
            $api->delete('post', 'PostController@destroy')
                ->name('api.auth.delete_post');

            // 删除评论
            $api->delete('comment', 'CommentController@destroy')
                ->name('api.auth.delete_comment');

            // 添加或修改分类
            $api->post('category', 'CategoryController@store')
                ->name('api.auth.add_category');

            // 删除分类
            $api->delete('category', 'CategoryController@destroy')
                ->name('api.auth.delete_category');

            // 获取举报列表
            $api->get('report/list', 'ReportController@get_list')
                ->name('api.auth.report_list');

            // 标记举报为已处理
            $api->post('report/dispose', 'ReportController@dispose')
                ->name('api.auth.dispose_report');

            // 标记举报为未处理
            $api->post('report/withdraw', 'ReportController@withdraw')
                ->name('api.auth.withdraw_report');

        });
    });
});
