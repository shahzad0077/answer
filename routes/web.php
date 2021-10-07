<?php

// use Illuminate\Support\Facades\Route;


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

// Auth
Route::get('/signin', [App\Http\Controllers\SignController::class, 'signin'])->name('signin');
Route::get('/signup', [App\Http\Controllers\SignController::class, 'signup'])->name('signup');
Route::get('auth/google', [App\Http\Controllers\SignController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\SignController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [App\Http\Controllers\SignController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [App\Http\Controllers\SignController::class, 'facebookSignin']);
Route::get('/my-profile', [App\Http\Controllers\HomeController::class, 'myprfile'])->name('myprofile');

Route::get('questionsitemap.xml', [App\Http\Controllers\SitemapController::class, 'questionsitemap']);
Route::get('blogpostssitemap.xml', [App\Http\Controllers\SitemapController::class, 'blogpostssitemap']);
Route::get('dynamicpagesitemap.xml', [App\Http\Controllers\SitemapController::class, 'dynamicpagesitemap']);

Route::get('search/{id}', [App\Http\Controllers\SiteController::class, 'searchnavbarpost']);

Route::get('question/{id}', [App\Http\Controllers\SiteController::class, 'singlequestion']);
Route::get('loadmorepage/{id}', [App\Http\Controllers\SiteController::class, 'loadmorepage']);

Route::get('tag/{id}', [App\Http\Controllers\SiteController::class, 'showbytags']);


// SiteController
Route::get('/', [App\Http\Controllers\SiteController::class, 'index'])->name('home');
Route::get('/{id}', [App\Http\Controllers\SiteController::class, 'checkurl']);
Route::get('/submitcontactus/{name}/{email}/{message}', [App\Http\Controllers\SiteController::class, 'submitcontactus']);
Route::get('addemailfornewsletter/{id}', [App\Http\Controllers\SiteController::class, 'addemailfornewsletter']);
Route::get('/checkslug/{id}', [App\Http\Controllers\SiteController::class, 'checkslug']);
Route::POST('expertrequest', [App\Http\Controllers\SiteController::class, 'expertrequest']);
Route::get('/getnotification/{id}', [App\Http\Controllers\SiteController::class, 'getnotification']);
Route::POST('createquestionuser', [App\Http\Controllers\SiteController::class, 'createquestion']);
Route::get('/searchnavbar/{id}', [App\Http\Controllers\SiteController::class, 'searchnavbar']);
Route::get('/deleteusernotification/{id}', [App\Http\Controllers\HomeController::class, 'deleteusernotification']);
Route::POST('advertisementrequest', [App\Http\Controllers\SiteController::class, 'advertisementrequest']);
Route::get('/savequestion/{id}', [App\Http\Controllers\SiteController::class, 'savequestion']);
Route::get('/unsavequestion/{id}', [App\Http\Controllers\SiteController::class, 'unsavequestion']);
Route::POST('saveblogcoment', [App\Http\Controllers\SiteController::class, 'saveblogcoment']);
Route::get('/questionratting/{id}/{two}', [App\Http\Controllers\SiteController::class, 'questionratting']);
Route::get('/likethisquestion/{id}', [App\Http\Controllers\SiteController::class, 'likethisquestion']);
Route::get('/unlikethisquestion/{id}', [App\Http\Controllers\SiteController::class, 'unlikethisquestion']);
Route::get('/answerratting/{id}/{two}', [App\Http\Controllers\SiteController::class, 'answerratting']);
Route::POST('blogsearch', [App\Http\Controllers\SiteController::class, 'blogsearch']);
Route::get('/addanswer/{id}', [App\Http\Controllers\SiteController::class, 'addanswershow']);
Route::get('admin/exportanswerquestion', [App\Http\Controllers\SiteController::class, 'exportanswerquestion']);
Route::get('/likeanswer/{id}', [App\Http\Controllers\SiteController::class, 'likeanswer']);
Route::get('/unlikeanswer/{id}', [App\Http\Controllers\SiteController::class, 'unlikeanswer']);
Route::get('/user-profile/{id}', [App\Http\Controllers\SiteController::class, 'publicprofile']);
Route::POST('updateblogcomentreply', [App\Http\Controllers\SiteController::class, 'updateblogcomentreply']);

Route::get('/user-profile/{id}/{answerd}', [App\Http\Controllers\SiteController::class, 'publicprofileanswers']);


// HomeController
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/profile/notifications', [App\Http\Controllers\HomeController::class, 'notifications'])->name('notifications');
Route::get('/profile/saved', [App\Http\Controllers\HomeController::class, 'saved'])->name('saved');
Route::get('/profile/answered', [App\Http\Controllers\HomeController::class, 'answered'])->name('answered');
Route::get('/profile/unanswered', [App\Http\Controllers\HomeController::class, 'unanswered'])->name('unanswered');
Route::get('/checkusername/{id}', [App\Http\Controllers\HomeController::class, 'checkusername']);


Route::get('/user/profile-settings', [App\Http\Controllers\HomeController::class, 'profilesettings'])->name('profilesettings');
Route::get('/support', [App\Http\Controllers\HomeController::class, 'support'])->name('profilesettings');
Route::get('/checkcode/{id}', [App\Http\Controllers\HomeController::class, 'checkcode'])->name('checkcode');
Route::get('/editquestion/{id}', [App\Http\Controllers\HomeController::class, 'editquestion'])->name('editquestion');
Route::get('/deleteimagequestion/{id}', [App\Http\Controllers\HomeController::class, 'deleteimagequestion']);
Route::POST('updatequestionuser', [App\Http\Controllers\HomeController::class, 'updatequestionuser']);
Route::POST('submitcomentreply', [App\Http\Controllers\HomeController::class, 'submitcomentreply']);
Route::POST('profilepicturechange', [App\Http\Controllers\HomeController::class, 'profilepicturechange']);




// Route::get('/home', [App\Http\Controllers\HomeController::class, 'redirecttodashboard'])->name('dashboard');


// Admin Routes Start


// Authentication Routes...

Route::POST('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/authentication/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Password Reset Routes...
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


Route::get('/admin/twofactor', [App\Http\Controllers\Auth\AdminLoginController::class, 'twofactorshow'])->name('twofactorshow');
Route::post('twofactor', [App\Http\Controllers\AdminController::class, 'twofactor'])->name('twofactor');
Route::get('/admin/resendcode', [App\Http\Controllers\AdminController::class, 'resendcode']);
Route::get('admin/dashboard', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.dashboard');
Route::get('/admin/login', [App\Http\Controllers\SiteController::class, 'adminlogin'])->name('admin.login');
Route::POST('adminlogin', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('adminlogin');




Route::get('changenoofrecordsperpage/{id}', [App\Http\Controllers\AdminController::class, 'changenoofrecordsperpage']);
Route::get('changestatusofnotifcation/{id}', [App\Http\Controllers\AdminController::class, 'changenotificationstatus']);

// Question Answer Module

Route::get('/admin/questions', [App\Http\Controllers\AdminController::class, 'questionsall']);
Route::get('/admin/questions/published', [App\Http\Controllers\AdminController::class, 'questionspublished']);
Route::get('/admin/questions/underreview', [App\Http\Controllers\AdminController::class, 'questionsunderreview']);
Route::get('/admin/questions/trash', [App\Http\Controllers\AdminController::class, 'questionstrash']);
Route::POST('deletequestion', [App\Http\Controllers\AdminController::class, 'deletequestion']);

Route::get('/admin/deleteimagequestionadmin/{trash}', [App\Http\Controllers\AdminController::class, 'deleteimagequestionadmin']);

Route::get('/admin/deletequestionpermanently/{id}', [App\Http\Controllers\AdminController::class, 'deletequestionpermanently']);
Route::POST('movetotrashquestion', [App\Http\Controllers\AdminController::class, 'movetotrashquestion']);
Route::POST('publishedquestion', [App\Http\Controllers\AdminController::class, 'publishedquestion']);
Route::POST('underreviewquestion', [App\Http\Controllers\AdminController::class, 'underreviewquestion']);
Route::POST('filterquestion', [App\Http\Controllers\AdminController::class, 'filterquestion']);
Route::POST('filteranswer', [App\Http\Controllers\AdminController::class, 'filteranswer']);

Route::POST('changebulkusersofall', [App\Http\Controllers\AdminController::class, 'changebulkusersofall']);

Route::get('/searchusers/{id}', [App\Http\Controllers\AdminController::class, 'searchusers']);



Route::get('admin/viewquestion/{id}', [App\Http\Controllers\AdminController::class, 'viewquestion']);
Route::POST('addanswer', [App\Http\Controllers\AdminController::class, 'addanswer']);
Route::get('viewsingleanswer/{id}', [App\Http\Controllers\AdminController::class, 'viewsingleanswer']);
Route::get('/admin/question/{id}/{answerid}', [App\Http\Controllers\AdminController::class, 'editanswer']);
Route::POST('updateanswer', [App\Http\Controllers\AdminController::class, 'updateanswer']);
Route::get('viewsinglequestionview/{id}', [App\Http\Controllers\AdminController::class, 'viewsinglequestionview']);
Route::get('admin/editquestion/{id}', [App\Http\Controllers\AdminController::class, 'editquestion']);
Route::POST('updatquestion', [App\Http\Controllers\AdminController::class, 'updatquestion']);
Route::get('admin/answers', [App\Http\Controllers\AdminController::class, 'answers']);
Route::POST('deleteanswer', [App\Http\Controllers\AdminController::class, 'deleteanswers']);
Route::get('admin/deleteanswertrash/{id}', [App\Http\Controllers\AdminController::class, 'deleteanswertrash']);
Route::get('admin/deleteanswerid/{id}', [App\Http\Controllers\AdminController::class, 'deleteanswerid']);
Route::POST('movetotrashanswer', [App\Http\Controllers\AdminController::class, 'movetotrashanswers']);
Route::POST('publishedanswer', [App\Http\Controllers\AdminController::class, 'publishedanswers']);
Route::POST('underreviewanswer', [App\Http\Controllers\AdminController::class, 'underreviewanswers']);
Route::get('/admin/answers/published', [App\Http\Controllers\AdminController::class, 'answerspublished']);
Route::get('/admin/answers/underreview', [App\Http\Controllers\AdminController::class, 'answersunderreview']);
Route::get('/admin/answers/trash', [App\Http\Controllers\AdminController::class, 'answerstrash']);
Route::POST('createquestion', [App\Http\Controllers\AdminController::class, 'createquestion']);
Route::get('/admin/add-question', [App\Http\Controllers\AdminController::class, 'addquestion']);

Route::get('/admin/deletequestion/{id}', [App\Http\Controllers\AdminController::class, 'deletequestiontrash']);
Route::get('searchanswer/{id}', [App\Http\Controllers\AdminController::class, 'searchanswer']);


Route::get('/admin/all-site-urls', [App\Http\Controllers\AdminController::class, 'allsiteurl']);



//  Information Module

Route::get('/admin/modules', [App\Http\Controllers\AdminController::class, 'modulesinformation']);
Route::get('/admin/editmodule/{id}', [App\Http\Controllers\AdminController::class, 'addinformation']);
Route::POST('updatemodule', [App\Http\Controllers\AdminController::class, 'updatemodule']);
Route::get('/changetopublish/{id}/{two}', [App\Http\Controllers\AdminController::class, 'changetopublish']);

// Blog Module

Route::get('/admin/add-blog', [App\Http\Controllers\AdminController::class, 'addblog']);
Route::POST('/createblog', [App\Http\Controllers\AdminController::class, 'createblog']);
Route::get('admin/blogs', [App\Http\Controllers\AdminController::class, 'blogs']);

Route::get('admin/blogs/{id}', [App\Http\Controllers\AdminController::class, 'blogswithid']);

Route::get('admin/blogslist', [App\Http\Controllers\AdminController::class, 'getblogslist'])->name('blogs.list');



Route::get('changetopublishblog/{one}/{two}', [App\Http\Controllers\AdminController::class, 'changetopublishblog']);
Route::get('deleteblog/{one}', [App\Http\Controllers\AdminController::class, 'deleteblog']);
Route::get('deleteblogtrash/{one}', [App\Http\Controllers\AdminController::class, 'deleteblogtrash']);



Route::get('/admin/edit/blog/{one}', [App\Http\Controllers\AdminController::class, 'editblog']);
Route::POST('/updateblog', [App\Http\Controllers\AdminController::class, 'updateblog']);
Route::POST('/updateblogimage', [App\Http\Controllers\AdminController::class, 'updateblogimage']);
Route::get('/admin/blog-categories', [App\Http\Controllers\AdminController::class, 'blogcategories']);
Route::get('/admin/blog/addnewcategory', [App\Http\Controllers\AdminController::class, 'addnewcategory']);
Route::POST('/createblogcategory', [App\Http\Controllers\AdminController::class, 'createblogcategory']);
Route::get('/admin/blogcategory/edit/{id}', [App\Http\Controllers\AdminController::class, 'editblogcategory']);
Route::POST('/updateblogcategory', [App\Http\Controllers\AdminController::class, 'updateblogcategory']);
Route::get('/admin/blogs-coments', [App\Http\Controllers\AdminController::class, 'blogcoments']);
Route::get('admin/deleteblogcoment/{id}', [App\Http\Controllers\AdminController::class, 'deleteblogcoment']);
Route::get('/admin/editblogcoment/{id}', [App\Http\Controllers\AdminController::class, 'editblogcoment']);
Route::POST('/updateblogcoment', [App\Http\Controllers\AdminController::class, 'updateblogcoment']);
Route::get('admin/deleteblogcomentreply/{id}', [App\Http\Controllers\AdminController::class, 'deleteblogcomentreply']);
Route::get('/deleteblogcategory/{id}', [App\Http\Controllers\AdminController::class, 'deleteblogcategory']);



// user
Route::get('/admin/all-users', [App\Http\Controllers\AdminController::class, 'viewallusers']);
Route::get('/deleteuser/{id}', [App\Http\Controllers\AdminController::class, 'deleteuser']);
Route::get('/changetopublishuser/{id}/{two}', [App\Http\Controllers\AdminController::class, 'changetopublishuser']);
Route::get('/searchusername/{id}', [App\Http\Controllers\AdminController::class, 'searchusername']);



Route::get('/admin/user/detail/{id}', [App\Http\Controllers\AdminController::class, 'userdetails']);
Route::get('/admin/user/detail/{id}/{answered}', [App\Http\Controllers\AdminController::class, 'userdetailsanswere']);

Route::get('/admin/expert-requests', [App\Http\Controllers\AdminController::class, 'expertrequests']);
Route::get('/makeexpert/{id}', [App\Http\Controllers\AdminController::class, 'makeexpert']);
Route::get('/removeexpert/{id}', [App\Http\Controllers\AdminController::class, 'removeexpert']);



Route::get('/admin/messages', [App\Http\Controllers\AdminController::class, 'messages']);
Route::get('/admin/view/message/{id}', [App\Http\Controllers\AdminController::class, 'viewmessage']);
Route::get('/deletecontactus/{id}', [App\Http\Controllers\AdminController::class, 'deletecontactus']);


// Testimonial
Route::get('/admin/alltestimonials', [App\Http\Controllers\AdminController::class, 'alltestimonials']);
Route::get('/admin/addnewtestimonials', [App\Http\Controllers\AdminController::class, 'addnewtestimonials']);
Route::POST('/createtestimonial',[App\Http\Controllers\AdminController::class, 'createtestimonial']);
Route::get('/deletetestimonial/{id}', [App\Http\Controllers\AdminController::class, 'deletetestimonial']);
Route::get('/admin/edittestimonial/{id}', [App\Http\Controllers\AdminController::class, 'edittestimonial']);
Route::POST('/updatetestimonials',[App\Http\Controllers\AdminController::class, 'updatetestimonials']);


// CMS
Route::get('/admin/cms/homepage', [App\Http\Controllers\AdminController::class, 'cmshomepage']);
Route::POST('/createhomepagesections', [App\Http\Controllers\AdminController::class, 'createhomepagesections']);
Route::get('/getcmshomepage/{id}', [App\Http\Controllers\AdminController::class, 'getcmshomepage']);
Route::POST('/updatecmshomepage', [App\Http\Controllers\AdminController::class, 'updatecmshomepage']);
Route::get('/admin/cms/faq', [App\Http\Controllers\AdminController::class, 'cmsfaq']);
Route::POST('/createfaq', [App\Http\Controllers\AdminController::class, 'createfaq']);
Route::POST('/updatefaq', [App\Http\Controllers\AdminController::class, 'updatefaq']);
Route::get('/deletefaq/{id}', [App\Http\Controllers\AdminController::class, 'deletefaq']);

Route::get('/admin/cms/realstories', [App\Http\Controllers\AdminController::class, 'cmsrealstories']);
Route::POST('/createrealstories', [App\Http\Controllers\AdminController::class, 'createrealstories']);
Route::get('/getrealstories/{id}', [App\Http\Controllers\AdminController::class, 'getrealstories']);
Route::POST('/updaterealstories', [App\Http\Controllers\AdminController::class, 'updatecmsrealstories']);
Route::get('/deleterealstories/{id}', [App\Http\Controllers\AdminController::class, 'deleterealstories']);
// Settings
Route::get('/admin/settings', [App\Http\Controllers\AdminController::class, 'settings']);
Route::get('/admin/email-settings', [App\Http\Controllers\AdminController::class, 'emailsettings']);
Route::get('/admin/payement-gatewaysettings', [App\Http\Controllers\AdminController::class, 'gatewaysettings']);
Route::get('/admin/theme-settings', [App\Http\Controllers\AdminController::class, 'themesettings']);
Route::POST('/updategenralsettings', [App\Http\Controllers\AdminController::class, 'updategenralsettings']);
Route::POST('/updateemailsettings', [App\Http\Controllers\AdminController::class, 'updateemailsettings']);
Route::POST('/updatepayementsettings', [App\Http\Controllers\AdminController::class, 'updatepayementsettings']);
Route::POST('/updatethemesettings', [App\Http\Controllers\AdminController::class, 'updatethemesettings']);
Route::get('admin/advertisements', [App\Http\Controllers\AdminController::class, 'advertisements']);
Route::get('admin/advertisementsdelte/{id}', [App\Http\Controllers\AdminController::class, 'advertisementsdelte']);
Route::POST('/saveadvertisements', [App\Http\Controllers\AdminController::class, 'saveadvertisements']);
Route::get('/admin/additional-css', [App\Http\Controllers\AdminController::class, 'additionalcss']);
Route::POST('/saveadditionalcss', [App\Http\Controllers\AdminController::class, 'saveadditionalcss']);
Route::get('admin/advertisementrequests', [App\Http\Controllers\AdminController::class, 'advertisementrequests']);
Route::get('admin/advertisementview/{id}', [App\Http\Controllers\AdminController::class, 'advertisementview']);



// Category
Route::get('admin/add-category', function () {
   return view('admin.categories.addcategory');
});
Route::get('admin/all-categories', [App\Http\Controllers\AdminController::class, 'categories']);
Route::get('admin/category/edit/{id}', [App\Http\Controllers\AdminController::class, 'editcategory']);
Route::POST('/createcategory', [App\Http\Controllers\AdminController::class, 'createcategory']);
Route::POST('/updatecategory', [App\Http\Controllers\AdminController::class, 'updatecategory']);
Route::get('/admin/deletecategory/{id}', [App\Http\Controllers\AdminController::class, 'deletecategory']);



// Admin Profile
Route::get('admin/profile', [App\Http\Controllers\AdminController::class, 'profile']);
Route::POST('/updateuserprofile', [App\Http\Controllers\HomeController::class, 'updateuserprofile']);
Route::POST('/updateusersecurity', [App\Http\Controllers\HomeController::class, 'updateusersecurity']);


// Admin Profile
Route::get('admin/add-user-roles', [App\Http\Controllers\AdminController::class, 'adduserroles']);
Route::get('admin/all-users-admin', [App\Http\Controllers\AdminController::class, 'allmanagers']);
Route::POST('/createuserrole', [App\Http\Controllers\AdminController::class, 'createuserrole']);
Route::POST('/updateuserrole', [App\Http\Controllers\AdminController::class, 'updateuserrole']);
Route::POST('/createadminuser', [App\Http\Controllers\AdminController::class, 'createadminuser']);
Route::POST('/updateadminuser', [App\Http\Controllers\AdminController::class, 'updateadminuser']);


// file-uplaoder
Route::get('admin/file-uplaoder', [App\Http\Controllers\AdminController::class, 'fileuplaoder']);
Route::get('/admin/createfile/{id}/{type}', [App\Http\Controllers\AdminController::class, 'createfile']);
Route::POST('/createfileabusivewords', [App\Http\Controllers\AdminController::class, 'createfileabusivewords']);
Route::POST('/createfileusers', [App\Http\Controllers\AdminController::class, 'createfileusers']);
Route::get('admin/abusive-words-file', [App\Http\Controllers\AdminController::class, 'abusivewordfileview']);
Route::get('admin/users-file', [App\Http\Controllers\AdminController::class, 'usersfileview']);
Route::POST('/uploadfile', [App\Http\Controllers\AdminController::class, 'uploadfile']);







// Dynamic Pages
Route::get('admin/add-page', [App\Http\Controllers\AdminController::class, 'addpage']);
Route::get('admin/all-pages', [App\Http\Controllers\AdminController::class, 'allpages']);
Route::get('admin/all-pages/{id}', [App\Http\Controllers\AdminController::class, 'allpageswithid']);
Route::get('admin/pages/edit/{id}', [App\Http\Controllers\AdminController::class, 'editpage']);
Route::POST('/createdynamicpage', [App\Http\Controllers\AdminController::class, 'createdynamicpage']);
Route::POST('/updatepage', [App\Http\Controllers\AdminController::class, 'updatepage']);
Route::get('admin/deletepage/{id}', [App\Http\Controllers\AdminController::class, 'deletepage']);



// Notifications
Route::get('admin/abusive-alerts', [App\Http\Controllers\AdminController::class, 'abusivealerts']);
Route::get('admin/media', [App\Http\Controllers\AdminController::class, 'media']);

Route::POST('/addmultipleimages', [App\Http\Controllers\AdminController::class, 'addmultipleimages']);
Route::get('admin/getallimagesof/{id}', [App\Http\Controllers\AdminController::class, 'getallimagesof']);
Route::POST('/updatemediaimage', [App\Http\Controllers\AdminController::class, 'updatemediaimage']);
Route::get('deletemediaimage/{id}/{table}', [App\Http\Controllers\AdminController::class, 'deletemediaimage']);



Route::get('/admin/newsletters', [App\Http\Controllers\AdminController::class, 'newsletters']);
Route::POST('/sendemailsnewsletters', [App\Http\Controllers\AdminController::class, 'sendemailsnewsletters']);


Route::get('/deleteglobelfunction/{id}/{tablename}', [App\Http\Controllers\AdminController::class, 'deleteglobelfunction']);
Route::get('/searchquestion/{id}', [App\Http\Controllers\AdminController::class, 'searchquestiontable']);
Route::get('/admin/sitemap', [App\Http\Controllers\AdminController::class, 'sitemap']);
Route::POST('/genratesitemap', [App\Http\Controllers\SitemapController::class, 'genratesitemap']);
Route::POST('/searchblog', [App\Http\Controllers\AdminController::class, 'searchblog']);
Route::get('searchtags/{id}', [App\Http\Controllers\AdminController::class, 'searchtags']);
Route::get('addtag/{blogid}/{tagid}', [App\Http\Controllers\AdminController::class, 'addtag']);
Route::get('deletetag/{blogid}/{tagid}', [App\Http\Controllers\AdminController::class, 'deletetag']);

Route::POST('/searchurl', [App\Http\Controllers\AdminController::class, 'searchurl']);

Route::get('/admin/url-redirection', [App\Http\Controllers\AdminController::class, 'urlredirection']);

Route::POST('/addnewredirect', [App\Http\Controllers\AdminController::class, 'addnewredirect']);

