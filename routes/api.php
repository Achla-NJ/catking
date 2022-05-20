<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')->group(function (){
    Route::any('get-colleges',[AdminController::class,'getColleges'])->name('admin.get-colleges');
    Route::any('get-states',[AdminController::class,'getStates'])->name('admin.get-states');
    Route::any('get-exams',[AdminController::class,'getExams'])->name('admin.get-exams');
    Route::any('get-users-table-data',[AdminController::class,'getUsersTableData'])->name('admin.get-users-table-data');
    Route::any('get-users-export-table-data',[AdminController::class,'getUsersExportTableData'])->name('admin.get-users-export-table-data');
    Route::any('get-users-sop-export-table-data',[AdminController::class,'getUsersSopExportTableData'])->name('admin.get-users-sop-export-table-data');
    Route::any('generate-users-export-file',[AdminController::class,'generateUsersExportFile'])->name('admin.generate-users-export-file');
    Route::any('generate-users-sop-export-file',[AdminController::class,'generateUsersSopExportFile'])->name('admin.generate-users-sop-export-file');
    Route::any('delete-users-export-file/{id?}',[AdminController::class,'deleteUsersExportFile'])->name('admin.delete-users-export-file');
    Route::any('delete-users-sop-export-file/{id?}',[AdminController::class,'deleteUsersSopExportFile'])->name('admin.delete-users-sop-export-file');
    Route::any('get-users-sop-data',[AdminController::class,'getUsersSopData'])->name('admin.get-users-sop-data');
    Route::any('sop-review',[AdminController::class,'sopReview'])->name('admin.sop-review');
    Route::any('sop-mail',[AdminController::class,'sopMail'])->name('admin.sop-mail');

    //dashboard routes
    Route::any('student',[DashboardController::class,'student'])->name('admin.student');
    Route::any('present-students',[DashboardController::class,'presentStudent'])->name('admin.present-students');
    Route::any('catking-students',[DashboardController::class,'catkingStudent'])->name('admin.catking-students');
    Route::any('exam',[DashboardController::class,'exam'])->name('admin.exam');
    Route::any('work',[DashboardController::class,'work'])->name('admin.work');
    Route::any('interview',[DashboardController::class,'interview'])->name('admin.interview');
    Route::any('profile-review',[DashboardController::class,'profileReview'])->name('admin.profile-review');
    Route::any('sop',[DashboardController::class,'sop'])->name('admin.sop');
    Route::any('score',[DashboardController::class,'score'])->name('admin.score');
    Route::any('score2',[DashboardController::class,'score2'])->name('admin.score2');
    Route::any('call',[DashboardController::class,'call'])->name('admin.call');
    Route::any('student-growth',[DashboardController::class,'studentGrowth'])->name('admin.student-growth');
    Route::any('catking-growth',[DashboardController::class,'catkingGrowth'])->name('admin.catking-growth');
    Route::any('profile-growth',[DashboardController::class,'profileGrowth'])->name('admin.profile-growth');
    Route::any('student-degree',[DashboardController::class,'studentDegree'])->name('admin.student-degree');
    Route::any('target',[DashboardController::class,'target'])->name('admin.target');
    Route::any('sop-submit',[DashboardController::class,'sopSubmit'])->name('admin.sop-submit');
    Route::any('dashboard-sop-review',[DashboardController::class,'sopReview'])->name('admin.dashboard-sop-review');
    Route::any('call-get',[DashboardController::class,'callGet'])->name('admin.call-get');
    Route::any('sop-performance',[DashboardController::class,'sopPerformance'])->name('admin.sop-performance');
    Route::any('call-performance',[DashboardController::class,'callPerformance'])->name('admin.call-performance');
    Route::any('top-state',[DashboardController::class,'topState'])->name('admin.top-state');

});
