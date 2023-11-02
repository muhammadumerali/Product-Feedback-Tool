<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status') || Auth::user()->getIsAdminAttribute()) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    else{
        return redirect()->route('user.home')->with('status', session('status'));
    }
});

Auth::routes();

Route::get('/user/register', function () {
    return view('auth.register');
})->name('user.register');

Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/feedback/create', 'FeedbackController@create')->name('feedback.create');
    Route::post('/feedback/store', 'FeedbackController@store')->name('feedback.store');
    Route::get('/feedback/comments', 'FeedbackController@comments')->name('feedback.getcomments');
    Route::get('/feedback/getcomments', 'FeedbackController@getcommentscount')->name('feedback.getcommentscount');
    Route::post('/vote/store', 'VoteController@store')->name('vote.add');
    Route::post('/comment/store', 'CommentController@store')->name('comment.save');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'mustAdminRole']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoryController');

    // Feedback
    Route::delete('feedbacks/destroy', 'FeedbackController@massDestroy')->name('feedbacks.massDestroy');
    Route::resource('feedbacks', 'FeedbackController');

    // Comment
    Route::delete('comments/destroy', 'CommentController@massDestroy')->name('comments.massDestroy');
    Route::post('comments/media', 'CommentController@storeMedia')->name('comments.storeMedia');
    Route::post('comments/ckmedia', 'CommentController@storeCKEditorImages')->name('comments.storeCKEditorImages');
    Route::resource('comments', 'CommentController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
