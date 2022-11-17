<?php

// Route::post('/register', 'Auth\AuthController@register');
// Route::post('/login', 'Auth\AuthController@login');
// Route::post('/logout', 'Auth\AuthController@logout');


// Route::get('/user', 'Auth\AuthController@user');




// Below mention routes are public, user can access those without any restriction.

use App\Http\Controllers\PaymentController;

Route::prefix('v1/')->group(function () {
    Route::post('/register', 'Auth\AuthController@register');
    Route::post('/login', 'Auth\AuthController@login');

    // password reset
    Route::post('/reset_password', 'AccountsController@resetPasswordRequest');
    Route::post('/reset_password_with_token', 'AccountsController@resetPassword');


    Route::get('/category/{category}/content/{id}', 'CategoryController@getContent');
    Route::get('/category/{category}/subject/{id}', 'CategoryController@getSubject');

    Route::get('/category/{category}/contents', 'CategoryController@getContent');
    Route::get('/category/{category}/subjects', 'CategoryController@getSubject');

    Route::get('/category/{id}', 'CategoryController@show');
    Route::get('/categories', 'CategoryController@index');

    Route::get('/sub_category/{id}', 'SubCategoryController@show');
    Route::get('/sub_categories', 'SubCategoryController@index');

    Route::get('/subject/{id}', 'SubjectController@show');
    Route::get('/subjects', 'SubjectController@index');
    Route::get('/my_subjects', 'SubjectController@mySubjects');
    Route::get('/my_courses', 'SubjectController@mySubjects');
    Route::get('/course/{id}', 'SubjectController@show');
    Route::get('/courses', 'SubjectController@index');

    Route::get('/content/{id}', 'ContentController@show');
    Route::get('/contents', 'ContentController@index');

    Route::get('/content_type/{id}', 'ContentTypeController@show');
    Route::get('/content_types', 'ContentTypeController@index');

    Route::get('/content_access/{id}', 'ContentAccessController@show');
    Route::get('/content_accesses', 'ContentAccessController@index');
    Route::get('/ratings', 'RatingController@index');

    Route::get('/media', 'MediaController@index');
    Route::get('/media/{id}', 'MediaController@show');

    Route::get('/tag', 'TagController@index');
    Route::get('/tags/{id}', 'TagController@show');


    // PayPal Routes
    Route::post('payment/handle', 'PayPalController@handle')->name('payment.handle');
    Route::post('donation/handle', 'DonationController@handle')->name('donation.handle');

    Route::post('/payment/execute-payment', 'PaymentController@terminal')->name('execute-payment');
    Route::get('/payment/verify_transaction', 'PaymentController@verifyPaystackTransaction')->name('verify');
});



Route::group(['prefix' => 'v1/',  'middleware' => 'api'], function () {
    Route::post('/logout', 'Auth\AuthController@logout');
    Route::get('/user', 'Auth\AuthController@user');
    Route::resource('notebooks', 'NoteBookController');
    Route::resource('notes', 'NoteController');
    Route::resource('interest_areas', 'UserInterestController');
    Route::post('/subject/subscribe', 'SubjectController@subscribe')->name('subject-subscribe');
    Route::post('/subject/unsubscribe', 'SubjectController@unSubscribe')->name('subject-unsubscribe');
    Route::post('/contents/register_consumed', 'ContentController@registerConsumedContent')->name('content-consume');
    Route::get('/contents/consumed', 'ContentController@getConsumedContents');
    Route::post('/change_password', 'AccountsController@changePassword');
    Route::post('/update_profile', 'AccountsController@updateProfile');
    Route::post('/post_review', 'ReviewController@store');
    Route::post('/post_contact_us', 'ContactController@store');
});



Route::group(['prefix' => 'v1/admin/',  'middleware' => 'api'], function () {
    Route::resource('/categories', 'CategoryController');
    Route::resource('/sub_categories', 'SubCategoryController');
    Route::resource('/topics', 'TopicController');
    Route::post('/contents', 'ContentController@store');
    Route::resource('/contents', 'ContentController');
    Route::resource('/content_types', 'ContentTypeController');
    Route::resource('/content_access', 'ContentAccessController');
    Route::resource('/tags', 'TagController');
    Route::resource('/subjects', 'SubjectController');
    Route::post('/change_password', 'AccountsController@changePassword');

    Route::resource('media', 'MediaController');
});

Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Resource not found!'
    ], 404);
});
