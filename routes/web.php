<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalIntertviewController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\UserCatResultController;
use App\Http\Controllers\UserXatResultController;
use App\Http\Controllers\UserIiftResultController;
use App\Http\Controllers\CatPredictorController;
use App\Http\Controllers\SettingController;
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



Route::post('/signup',[AuthController::class,'signup'])->name('signup');
Route::post('/signin',[AuthController::class,'signin'])->name('signin');

Route::get('/forgot-password',[AuthController::class,'passwordForgot'])->name('password-forgot');
Route::post('/password-reset-otp',[AuthController::class,'passwordResetOtp'])->name('password-reset-otp');
Route::get('/reset-password',[AuthController::class,'passwordReset'])->name('password-reset');
Route::post('/new-password',[AuthController::class,'newPassword'])->name('new-password');


Route::group(['middleware'=>'guest'],function(){
    Route::get('/register',[AuthController::class,'index'])->name('regiter-view');
    Route::get('/login',[AuthController::class,'login'])->name('login');
});
Route::group(['middleware'=> 'auth'],function(){

    // Routes for Admin Only
    Route::as('admin.')->middleware('is_admin')->prefix('admin')->group(function(){
        Route::get('dashboard',function(){return view('admin.dashboard');})->name('dashboard');
        Route::get('users',function(){return view('admin.users');})->name('view');
        Route::get('user-view/{user_id}',[UserController::class,'account'])->name('user-view');
        Route::get('exams/{user_id}',[UserController::class,'Exams'])->name('exams');
        Route::get('sops/{user_id}',[UserController::class,'Sops'])->name('sops');
        Route::get('interview/{user_id}',[UserController::class,'ReceivedCall'])->name('receivedcall');
         
        Route::get('users/export',[AdminController::class,'userExport'])->name('export');
        Route::get('users/export/download-file/{file_name?}',[AdminController::class,'downloadUsersExportFile'])->name('users-export-download-file');
        Route::get('users-sop/export/download-file/{file_name?}',[AdminController::class,'downloadUsersSopExportFile'])->name('users-sop-export-download-file');
        Route::get('users/sop-export',[AdminController::class,'sopExport'])->name('sop-export');

        Route::get('colleges',[CollegeController::class,'index'])->name('college');
        Route::get('delete-college/{college}',[CollegeController::class,'destroy'])->name('delete-college');
        Route::get('get-college',[CollegeController::class,'fetch'])->name('get-college');
        Route::post('update-college',[CollegeController::class,'update'])->name('update-college');
        Route::get('college-status',[CollegeController::class,'status'])->name('college-status');

        Route::get('exams',[ExamController::class,'index'])->name('exam');
        Route::get('delete-exam/{exam}',[ExamController::class,'destroy'])->name('delete-exam');
        Route::get('get-exam',[ExamController::class,'fetch'])->name('get-exam');
        Route::post('update-exam',[ExamController::class,'update'])->name('update-exam');
        Route::post('insert-exam',[ExamController::class,'store'])->name('insert-exam');
        Route::get('exam-status',[ExamController::class,'status'])->name('exam-status');

        Route::get('pages',[CustomPageController::class,'index'])->name('pages');
        Route::get('delete-page/{page}',[CustomPageController::class,'destroy'])->name('delete-page');

        Route::get('edit-page/{id}',[CustomPageController::class,'fetch'])->name('get-page');
        Route::post('update-page',[CustomPageController::class,'update'])->name('update-page');

        Route::get('create',function(){return view('admin.custompage');})->name('custom-page');
        Route::post('insert-page',[CustomPageController::class,'store'])->name('insert-page');

        Route::get('review/attributes',[AttributeController::class,'index'])->name('attributes');
        Route::view('review/personal-interviews','admin.personal-interviews')->name('personal-interviews');
        Route::view('review/profile','admin.profile-review')->name('profile-review');
        Route::get('change-password',[UserController::class,'changeAdminPassword'])->name('change-password');
        Route::post('update-password',[UserController::class,'updateAdminPassword'])->name('update-password');

        Route::get('broadcast-message',[AdminController::class,'broadcastMessage'])->name('broadcast-message');
        Route::post('update-broadcast-message',[AdminController::class,'updateBroadcastMessage'])->name('update-broadcast-message');
        Route::post('search-pi-student',[ReviewController::class,'searchPiInterview'])->name('search-pi-student');
        Route::post('store-pi-review',[ReviewController::class,'storePireview'])->name('store-pi-review');
        Route::get('delete-review',[ReviewController::class,'delete'])->name('delete-review');
        Route::get('email-review',[ReviewController::class,'emailSend'])->name('email-review');
        Route::post('store-attributes',[AttributeController::class,'store'])->name('store-attributes');
        

    });
    //End Routes for Admin

    Route::get('/signout',[AuthController::class,'signOut'])->name('signout');
    Route::get('/',[UserController::class,'account'])->name('home');

    Route::as('profile.')->prefix('profile')->group(function(){
        Route::get('/',[UserController::class,'account'])->name('view');
        Route::get('account',[UserController::class,'account'])->name('account');
        Route::get('change-password',[UserController::class,'changePassword'])->name('change-password');
        Route::post('update-password',[UserController::class,'updatePassword'])->name('update-password');
        Route::post('update-profile',[UserController::class,'updateProfile'])->name('update-profile');
        Route::post('update-personalinfo',[UserController::class,'updatePersonalInfo'])->name('update-personalinfo');
        Route::post('update-education',[UserController::class,'updateEducation'])->name('update-education');
        Route::post('update-workexaperience',[UserController::class,'updateWorkExperience'])->name('update-workexaperience');
        Route::post('update-exam',[UserController::class,'updateExam'])->name('update-exam');
        Route::post('scorecard',[UserController::class,'scoreCard'])->name('scorecard');
        Route::post('sop',[UserController::class,'sop'])->name('sop');
        Route::post('call',[UserController::class,'call'])->name('call');
        Route::post('update-sop',[UserController::class,'updateSop'])->name('update-sop');
        Route::post('add-work',[UserController::class,'addWork'])->name('add-work');
        Route::post('add-dreamcollege',[UserController::class,'addDreamCollege'])->name('add-dreamcollege');
        Route::post('update-dreamcollege',[UserController::class,'updateDreamCollege'])->name('update-dreamcollege');
        Route::post('update-allcall',[UserController::class,'updateAllCall'])->name('update-allcall');
        Route::post('add-call',[UserController::class,'addCall'])->name('add-call');
        Route::post('add-education',[UserController::class,'addEducation'])->name('add-education');
        Route::post('add-exam',[UserController::class,'addExam'])->name('add-exam');
        Route::post('add-college',[UserController::class,'addCollege'])->name('add-college');
        Route::get('review',[UserController::class,'review'])->name('review');
        Route::post('add-otherinput',[UserController::class,'addOtherInput'])->name('add-otherinput');
        Route::get('exams',[UserController::class,'Exams'])->name('exams');
        Route::get('sops',[UserController::class,'Sops'])->name('sops');
        Route::get('interview',[UserController::class,'ReceivedCall'])->name('receivedcall');

        Route::post('add-curricular',[UserController::class,'addCurricular'])->name('add-curricular');
        Route::post('add-extradetail',[UserController::class,'addExtraDetail'])->name('add-extradetail');
        Route::post('update-curricular',[UserController::class,'updateCurricular'])->name('update-curricular');
        Route::get('update-work-hard',[UserController::class,'updateWorkHardStatus'])->name('update-work-hard');
    });



Route::post('insert-college',[CollegeController::class,'store'])->name('insert-college');

Route::get('/personal-interviews',[ReviewController::class,'pinterview'])->name('pi');
Route::get('/profile-reviews',[ReviewController::class,'profile'])->name('profile');
Route::get('/watpi-and-cdpi',[UserController::class,'watpi'])->name('watpi');
Route::get('/user-files/{file_name}',[UserController::class,'userFiles'])->name('user-files');

Route::get('score-calculator/cat',[UserCatResultController::class,'index'])->name('cat-result');
Route::post('user-cat-result',[UserCatResultController::class,'catResult'])->name('user-cat-result');

Route::get('score-calculator/xat',[UserXatResultController::class,'index'])->name('xat-result');
Route::post('user-xat-result',[UserXatResultController::class,'xatResult'])->name('user-xat-result');

Route::get('score-calculator/iift',[UserIiftResultController::class,'index'])->name('iift-result');
Route::post('user-iift-result',[UserIiftResultController::class,'iiftResult'])->name('user-iift-result');
Route::get('predictor/cat',[CatPredictorController::class,'index'])->name('cat-predictor');
Route::get('pp_cat_result',function(){return view('user.pp_cat_result');})->name('pp_cat_result');
Route::post('cat-predictor-process',[CatPredictorController::class,'process'])->name('cat-predictor-process');

Route::get('cat-score',[CatPredictorController::class,'scoreView'])->name('cat-score');
Route::post('cat-score-predictor',[CatPredictorController::class,'score'])->name('cat-score-predictor');

Route::get('view-page/{slug}',[CustomPageController::class,'view'])->name('view-page');
Route::get('new-page/{id}',[CustomPageController::class,'newpage'])->name('new-page');

});
Route::get('command/{command}', function ($command){
    if($command == 'reset'){
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('route:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);

        \Illuminate\Support\Facades\Artisan::call('config:cache');
        $result = \Illuminate\Support\Facades\Artisan::output();
        dump($result);
        die;
    }else{
        \Illuminate\Support\Facades\Artisan::call($command);
        $result = \Illuminate\Support\Facades\Artisan::output();
    }
    dd($result);
    
})->name('command.run');