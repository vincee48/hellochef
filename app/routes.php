<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Main
Route::get('/', 'HomeController@home');
Route::get('/terms', 'HomeController@terms');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/browse', 'HomeController@gallery');
Route::get('/faq', 'HomeController@faq');

// Images
Route::get('/images/{userid}/{file}', 'ImageController@getImage');
Route::get('/images/{userid}/{file}/delete', 'ImageController@deleteImage');
Route::post('/my/settings/profile/crop', 'ImageController@cropImage');

// Attachments
Route::get('/my/become-a-chef/step-3/attachments', array('before' => 'authnochef', 'uses' => 'AttachmentController@chefStep3'));
Route::post('/my/become-a-chef/step-3/attachments', array('before' => 'authnochef', 'uses' => 'AttachmentController@postChefStep3'));
Route::get('/my/settings/menu/{id}/attachments', array('before' => 'auth', 'uses' => 'AttachmentController@menuAttachments'));
Route::post('/my/settings/menu/{id}/attachments', array('before' => 'auth', 'uses' => 'AttachmentController@postMenuAttachments'));
Route::post('/my/settings/menu/{id}/update', array('before' => 'auth', 'as' => 'menu.image.update', 'uses' => 'AttachmentController@updateMenuAttachments'));

// Setting
Route::get('/my/settings', array('before' => 'auth', 'uses' => 'SettingController@settings'));
Route::get('/my/settings/profile', array('before' => 'authischef', 'uses' => 'SettingController@settingsProfile'));
Route::get('/my/settings/account', array('before' => 'auth', 'uses' => 'SettingController@settingsAccount'));
Route::get('/my/settings/menu', array('before' => 'authischef', 'uses' => 'SettingController@settingsMenu'));
Route::post('/user/{id}/updateProfile', array('before' => 'auth', 'as' => 'user.updateProfile', 'uses' => 'SettingController@updateProfile'));
Route::post('/user/{id}/updateAccount', array('before' => 'auth', 'as' => 'user.updateAccount', 'uses' => 'SettingController@updateAccount'));

// Menu
Route::get('/my/settings/menu/add', array('before' => 'authischef', 'uses' => 'MenuController@addMenu'));
Route::post('/my/settings/menu/add', array('before' => 'authischef', 'uses' => 'MenuController@postAddMenu'));
Route::get('/my/settings/menu/{id}', array('before' => 'authischef', 'uses' => 'MenuController@editMenu'));
Route::post('/my/settings/menu/{id}', array('before' => 'authischef', 'uses' => 'MenuController@postEditMenu'));
Route::get('/my/settings/menu/{id}/unpublish', array('before' => 'authischef', 'uses' => 'MenuController@unpublishMenu'));
Route::get('/my/settings/menu/{id}/publish', array('before' => 'authischef', 'uses' => 'MenuController@publishMenu'));
Route::get('/my/settings/menu/{id}/add', array('before' => 'authischef', 'uses' => 'MenuController@addMenuItem'));
Route::post('/my/settings/menu/{id}/add', array('before' => 'authischef', 'uses' => 'MenuController@postAddMenuItem'));
Route::get('/my/settings/menu/{id}/{menuitemid}', array('before' => 'authischef', 'uses' => 'MenuController@editMenuItem'));
Route::post('/my/settings/menu/{id}/{menuitemid}', array('before' => 'authischef', 'uses' => 'MenuController@postEditMenuItem'));
Route::get('/my/settings/menu/{id}/{menuitemid}/publish', array('before' => 'authischef', 'uses' => 'MenuController@publishMenuItem'));
Route::get('/my/settings/menu/{id}/{menuitemid}/unpublish', array('before' => 'authischef', 'uses' => 'MenuController@unpublishMenuItem'));

// User
Route::get('/confirm', 'UserController@confirm');
Route::post('/confirm', 'UserController@resendConfirmation');
Route::get('/confirmed', array('before' => 'auth', 'uses' => 'UserController@confirmed'));
Route::get('/confirm/{id}/{confirmation}', 'UserController@confirmAccount');
Route::get('/signin', 'UserController@getLogin');
Route::get('/logout', 'UserController@logout');
Route::get('/signup', 'UserController@getSignup');
Route::post('/signup', 'UserController@postSignup');
Route::post('/signin', 'UserController@postLogin');
Route::get('/reset', 'UserController@getReset');
Route::post('/reset', 'UserController@postReset');
Route::get('/reset/{id}/{reset}', 'UserController@getResetPassword');
Route::post('/reset/{id}/{reset}', 'UserController@postResetPassword');

// Mailbox
Route::get('/my/mailbox', array('before' => 'auth', 'uses' => 'MailController@mailbox'));
Route::get('/my/mailbox/sent', array('before' => 'auth', 'uses' => 'MailController@sentMailbox'));
Route::get('/my/mailbox/{id}', array('before' => 'auth', 'uses' => 'MailController@getMail'));
Route::get('/my/mailbox/sent/{id}', array('before' => 'auth', 'uses' => 'MailController@getSentMail'));
Route::post('/my/mailbox/{id}', array('before' => 'auth', 'uses' => 'MailController@replyMail'));
Route::post('/my/mailbox/enquiry/{id}', array('before' => 'auth', 'as' => 'message-board.update', 'uses' => 'MailController@replyEnquiry'));

// Enquiry
Route::get('/my/enquiries', array('before' => 'auth', 'uses' => 'EnquiryController@myEnquiries'));
Route::get('/my/enquiries/{id}', array('before' => 'auth', 'uses' => 'EnquiryController@getEnquiry'));
Route::get('/my/chef/enquiries', array('before' => 'authischef', 'uses'=> 'EnquiryController@chefEnquiries'));
Route::get('/my/chef/enquiries/confirm', array('before' => 'authischef', 'uses' => 'EnquiryController@getConfirmEnquiries'));
Route::get('/my/chef/enquiries/{id}/confirm', array('before' => 'authischef', 'uses' => 'EnquiryController@confirmEnquiry'));
Route::post('/my/enquiries/{id}', array('before' => 'auth', 'uses' => 'EnquiryController@payEnquiry'));
Route::post('/chef/{chefname}/{menuid}', 'EnquiryController@postEnquiry');
Route::post('/my/enquiries/{id}/update', array('before' => 'auth', 'as' => 'enquiry.update', 'uses' => 'EnquiryController@updateEnquiry'));
Route::post('/my/enquiries/{id}/amend', array('before' => 'auth', 'as' => 'enquiry.amend', 'uses' => 'EnquiryController@amend'));

// Reviews
Route::get('/my/reviews', array('before' => 'auth', 'uses' => 'ReviewController@getReviews'));
Route::post('/my/reviews', array('before' => 'auth', 'uses' => 'ReviewController@postReviews'));

// Chefs
Route::get('/chef/{chefname}', 'ChefController@getProfile');
Route::get('/chef/{chefname}/{menuid}', 'ChefController@getMenu');

// Leads
Route::get('/my/become-a-chef/latest', array('before' => 'authnochef', 'uses' => 'LeadController@latestEnquiry'));
Route::get('/my/become-a-chef/step-{page}', array('before' => 'authnochef', 'uses' => 'LeadController@enquiry'));
Route::post('/my/become-a-chef/step-1', array('before' => 'authnochef', 'as' => 'chef.enquire.step1', 'uses' => 'LeadController@postStepOne'));
Route::post('/my/become-a-chef/step-1', array('before' => 'authnochef', 'as' => 'chef.enquire.step1.save', 'uses' => 'LeadController@postStepOne'));
Route::post('/my/become-a-chef/step-2', array('before' => 'authnochef', 'as' => 'chef.enquire.step2', 'uses' => 'LeadController@postStepTwo'));
Route::post('/my/become-a-chef/step-3', array('before' => 'authnochef', 'as' => 'chef.enquire.step3', 'uses' => 'LeadController@postStepThree'));
Route::get('/my/become-a-chef/step-4/add', array('before' => 'authnochef', 'uses' => 'LeadController@getAddNewMenuItem'));
Route::post('/my/become-a-chef/step-4/add', array('before' => 'authnochef', 'as' => 'chef.menuitem.add', 'uses' => 'LeadController@postAddNewMenuItem'));
Route::post('/my/become-a-chef/step-4/action', array('before' => 'authnochef', 'as' => 'chef.menuitem.performaction', 'uses' => 'LeadController@menuItemPerformAction'));
Route::post('/my/become-a-chef/step-4/submit', array('before' => 'authnochef', 'as' => 'chef.submitforapproval', 'uses' => 'LeadController@postStepFour'));
Route::get('/my/become-a-chef/step-4/edit', array('before' => 'authnochef', 'uses' => 'LeadController@getEditMenuItem'));
Route::post('/my/become-a-chef/step-4/edit/{id}', array('before' => 'authnochef', 'as' => 'chef.menuitem.edit', 'uses' => 'LeadController@postEditMenuItem'));
Route::get('/my/become-a-chef/step-4/delete', array('before' => 'authnochef', 'uses' => 'LeadController@deleteMenuItem'));
Route::post('/my/become-a-chef/step-5', array('before' => 'authnochef', 'uses' => 'LeadController@submitForApproval'));
Route::get('/my/become-a-chef/step-4/{menuid}/{menuitemid}/unpublish', array('before' => 'authnochef', 'uses' => 'LeadController@unpublishMenuItem'));

// Admin
Route::get('/admin/dashboard', array('before' => 'authisadmin', 'uses' => 'AdminController@dashboard'));
Route::get('/admin/users', array('before' => 'authisadmin', 'uses' => 'AdminController@users'));
Route::get('/admin/users/{id}', array('before' => 'authisadmin', 'uses' => 'AdminController@getUser'));
Route::get('/admin/enquiries', array('before' => 'authisadmin', 'uses' => 'AdminController@enquiries'));
Route::get('/admin/cuisines', array('before' => 'authisadmin', 'uses' => 'AdminController@cuisines'));
Route::get('/admin/cuisines/add', array('before' => 'authisadmin', 'uses' => 'AdminController@cuisinesAdd'));
Route::post('/admin/cuisines/add', array('before' => 'authisadmin', 'uses' => 'AdminController@cuisinesAddPost'));
Route::get('/admin/cuisines/{id}/publish', array('before' => 'authisadmin', 'uses' => 'AdminController@publishCuisine'));
Route::get('/admin/cuisines/{id}/unpublish', array('before' => 'authisadmin', 'uses' => 'AdminController@unpublishCuisine'));
Route::get('/admin/leads', array('before' => 'authisadmin', 'uses' => 'AdminController@leads'));
Route::get('/admin/leads/{id}', array('before' => 'authisadmin', 'uses' => 'AdminController@viewLead'));
Route::get('/admin/leads/{id}/qualify', array('before' => 'authisadmin', 'uses' => 'AdminController@qualifyLead'));
Route::get('/admin/leads/{id}/{menuid}', array('before' => 'authisadmin', 'uses' => 'AdminController@viewLeadMenu'));
Route::get('/admin/mailbox', array('before' => 'authisadmin', 'uses' => 'AdminController@viewMailbox'));
Route::get('/admin/mailbox/{id}', array('before' => 'authisadmin', 'uses' => 'AdminController@getMail'));
Route::get('/admin/chef/{chefname}', array('before' => 'authisadmin', 'uses' => 'AdminController@getChef'));
Route::post('/admin/{userid}/profile/crop', 'ImageController@adminCropImage');

// Scripts
Route::get('/admin/migrate/cuisines-to-tags', array('before' => 'authisadmin', 'uses' => 'AdminController@migrateCuisines'));