<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() { return view('home'); })->name('welcome');
Route::get('/', function () { return view('home'); })->name('index');
Route::get('/home', function () { return view('home'); })->name('home');

Route::post('reset_password_with_token', 'AccountsController@resetPassword');
Route::post('password/reset/{token}', 'AccountsController@resetPassword');

Route::group(['prefix' => 'admin/auth/', 'middleware' => ['guest']], function () {

    // Social Login
    // Route::get('login/{provider}', 'SocialController@redirect');

    // Route::get('login/{provider}/callback','SocialController@Callback');

    // Route::get('/login', function () {
    //     return view('auth.login');
    // })->name('login');
    // Route::get('/register', function () {
    //     return view('auth.register');
    // })->name('register');
    Route::get('/reset-password', function () {
        return view('auth.reset-password');
    })->name('reset-password');
    // Route::get('/change-password', function () {
    //     return view('auth.change-password');
    // })->name('change-password');
});

Route::group(['prefix' => 'admin/', 'middleware' => 'auth:web,api'], function () {
    Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('change-password');
    Route::post('/change-password', 'Auth\ChangePasswordController@store')->name('change-password');
  
    // Contents routes
    Route::get('/', 'HomeController@dashboard');
    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('/student', 'StudentController@student')->name('student');

    Route::get('/content', 'ContentController@getAll')->name('content');
    Route::get('/content/{id}', 'ContentController@view')->name('show-content');
    Route::get('/contents/add', 'ContentController@create')->name('add-content');
    Route::get('/content/{id}/delete', 'ContentController@delete')->name('delete-content');
    Route::get('/contents/create', 'ContentController@create')->name('add-content');
    Route::post('/content/newContent', 'ContentController@createContent')->name('content-upload');
    Route::get('/content/{id}/unpublish', 'ContentController@unPublishContent')->name('unpublish-content');
    Route::get('/content/{id}/publish', 'ContentController@publishContent')->name('publish-content');
    Route::get('/content/{id}/edit', 'ContentController@edit')->name('edit-content');
    Route::post('/content/{id}', 'ContentController@updateContent')->name('update-content');


    // CONTENT CATEGORIES
    Route::get('/category', 'CategoryController@showAll')->name('category');
    Route::get('/category/add',  'CategoryController@create')->name('add-category');
    Route::get('/category/create', 'CategoryController@create')->name('add-category');
    Route::get('/category/{id}',  'CategoryController@view')->name('show-category');
    Route::get('/category/{id}/edit',  'CategoryController@edit')->name('edit-category');
    Route::get('/category/{id}/delete',  'CategoryController@delete')->name('delete-category');
    Route::post('/category/update/edit',  'CategoryController@edit')->name('edit-category-form');
    Route::post('/category/create',  'CategoryController@addNew')->name('new-category');


    // TOPICS
    Route::get('/topic', 'TopicController@showAll')->name('topic');
    Route::get('/topic/add',  'TopicController@create')->name('add-topic');
    Route::get('/topic/create', 'TopicController@create')->name('add-topic');
    Route::get('/topic/{id}/edit',  'TopicController@edit')->name('edit-topic');
    Route::get('/topic/{id}/delete',  'TopicController@delete')->name('delete-topic');
    Route::post('/topic/update/edit',  'TopicController@edit')->name('edit-topic-form');
    Route::post('/topic/create',  'TopicController@addNew')->name('new-topic');

    // POST
    Route::resource('/post', 'PostController');
    Route::any('/comment/publish/{id}', 'PostController@publishComment')->name('comment.publish');
    Route::any('/comment/unpublish{id}', 'PostController@unpublishComment')->name('comment.unpublish');

    // SUBJECTS
    Route::get('/subject', 'SubjectController@showAll')->name('subject');
    Route::get('/subject/add',  'SubjectController@create')->name('add-subject');
    Route::get('/subject/create', 'SubjectController@create')->name('add-subject');
    Route::get('/subject/{id}',  'SubjectController@view')->name('show-subject');
    Route::get('/subject/{id}/edit',  'SubjectController@edit')->name('edit-subject');
    Route::get('/subject/{id}/delete',  'SubjectController@delete')->name('delete-subject');
    Route::post('/subject/update/edit',  'SubjectController@updateSubject')->name('update-subject');
    Route::post('/subject/create',  'SubjectController@addNew')->name('new-subject');

    // TAGS
    Route::get('/tag', 'TagController@showAll')->name('tag');
    Route::get('/tag/add',  'TagController@create')->name('add-tag');
    Route::get('/tag/create', 'TagController@create')->name('add-tag');
    Route::get('/tag/{id}/edit',  'TagController@edit')->name('edit-tag');
    Route::get('/tag/{id}/delete',  'TagController@delete')->name('delete-tag');
    Route::post('/tag/update/edit',  'TagController@updateTag')->name('update-tag');
    Route::post('/tag/create',  'TagController@addNew')->name('new-tag');

    // REVIEW & CONTACT MESSAGES
    Route::get('/review_messages', 'ContactController@showAll')->name('review-messages');
    Route::get('/reviews', 'ReviewController@showAll')->name('reviews');
    Route::get('/messages', 'ContactController@showAll')->name('messages');
    Route::get('/review/{id}', 'ReviewController@view')->name('show-review');
    Route::get('/message/{id}', 'ContactController@view')->name('show-message');

    Route::get('/profile', function () { return view('pages.profile.index'); })->name('profile');

    Route::get('/profile/{id}/', function () { return view('pages.profile.index'); })->name('view-profile');

    Route::get('/profile/{id}/edit', function () { return view('pages.profile.edit'); })->name('edit-profile');
});



Route::group(['middleware' => 'auth:web,api'], function () {
  Route::any('/logout', 'Auth\LogoutController@logOut')->name('logout');
});

Auth::routes();