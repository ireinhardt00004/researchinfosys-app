<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ManuscriptController;
use App\Http\Controllers\SubController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\CompletedResearchController;
use App\Http\Controllers\UtilizedController;
use App\Http\Controllers\CitationController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\ResearchAwardController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\DropBoxController;

// Route::get('/load', function () {
//     return view('chats.index');
// });
Route::get('/load', function () {
    return view('preloader');
});
    //HOME PAGE 
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/success-message',[RegisteredUserController::class,'success'])->name('registration.success');

    Route::post('/contact/submit', [ContactUsController::class, 'send'])->name('contact.submit');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//Route for authenticated
Route::middleware('auth')->group(function () {
    //admin dashboard
    Route::get('/admin-dashboard',[AdminController::class,'index'])->name('admin.dashboard');
     //subadmin dashboard
    Route::get('/sub-dashboard',[AdminController::class,'subIndex'])->name('sub.dashboard');
     //user dashboard
    Route::get('/dashboard',[AdminController::class,'userIndex'])->name('user.dashboard');
    //ACTIVITY LOGS
    Route::get('/activity-logs',[ActivityLogController::class, 'index'])->name('activity.logsindex');
    Route::get('/all/activity-logs',[ActivityLogController::class, 'adminLog'])->name('activity.logsadmin');
    Route::delete('/activity-log/{user_id}',[ActivityLogController::class,'destroy']);
    //export all logs
    Route::get('/export-all/logs',[ActivityLogController::class,'exportToExcel'])->name('export.activity.log');
    Route::get('/export-my/logs',[ActivityLogController::class,'exportLogToExcel'])->name('export.my-activity.log');
    
    //chats
     Route::get('/chat',[ChatController::class,'index'])->name('chats.index');
     
     //report
     Route::get('/admin-report',[ReportController::class,'adminIndex'])->name('reports.admin-index');
     Route::get('/admin-kra',[ReportController::class,'adminKra'])->name('admin-kraindex');
     Route::get('/manuscripts/list',[ReportController::class,'index'])->name('reports.index');
     Route::get('/manuscript/all',[ReportController::class,'adminManViewer'])->name('manuscriptall-lists');
     Route::get('/manuscripts/view/{id}',[ManuscriptController::class,'viewManuscripts'])->name('manuscripts.viewz');
     //Newsfeed
     Route::get('/news-and-announcement',[NewsFeedController::class,'index'])->name('newsfeed.index');
     Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
     Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
     // Edit announcement
     Route::get('/announcements/edit/{id}', [AnnouncementController::class, 'edit'])->name('announcements.edit');
     Route::post('/announcements/update/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
     // Delete announcement
     Route::delete('/announcements/destroy/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
 

     //account management
     Route::get('/admin/user-list',[AccountManagementController::class,'userlist'])->name('accountmng.userlist');
     Route::post('/admin/edit-credentials/{id}', [AccountManagementController   ::class, 'editCredentials'])->name('admin.edit-credentials');
     Route::post('/admin/delete-user/{id}', [AccountManagementController    ::class, 'deleteUser'])->name('admin.delete-user');
    
     Route::get('/validate/account',[AccountManagementController::class,'index'])->name('accountmng.index');
     Route::post('/admin/verify-user/approve/{id}', [AccountManagementController::class, 'approveUser'])->name('user.approve');
     Route::post('/admin/verify-user/decline/{id}', [AccountManagementController::class, 'declineUser'])->name('user.decline');
     
     Route::get('/admin/permission',[StaffController::class,'index'])->name('accountmng.permissions');
     Route::post('/admin/register-staff', [StaffController::class, 'registerStaff']);
     Route::post('/admin/subedit-credentials/{id}', [StaffController::class, 'editCredentials'])->name('admin.edit.credentials');
     Route::post('/admin/subdelete-user/{id}', [StaffController::class, 'deleteUser'])->name('admin.delete.user');
    //Data management
    Route::get('/data-management',[DataManagementController::class,'index'])->name('datamng.index');
    
    //EVENT CONTROLLER
     //EVENT CALENDAR
     Route::get('/admin-event/calendar',[EventController::class,'index'])->name('admin.event-calendar');
     Route::post('/store-events', [EventController::class,'store'])->name('events.store');
     Route::delete('/events/delete/{id}', [EventController::class, 'destroy'])->name('events.destroy');
   


     //CONTACT US DASHBOARD
    Route::get('/contact-us/list', [ContactUsController::class, 'index'])->name('contact.index');
     // Route to view contact details
    Route::get('/contact-us/{id}', [ContactUsController::class, 'viewContactUs'])->name('contact.view');
    // Route to reply to a contact
    Route::post('/contact-us/reply/{id}', [ContactUsController::class, 'replyContactUs'])->name('contact.reply');
    Route::delete('/contact-us/{user_id}',[ContactUsController::class,'destroy']);
   
   //submt  manuscript index user
   Route::get('/manuscript',[ManuscriptController::class,'submitIndex'])->name('manuscript.index');
   Route::post('/manuscripts/store', [ManuscriptController::class, 'store'])->name('manuscripts.store');
   Route::delete('/manuscripts/{id}', [ManuscriptController::class, 'destroy'])->name('manuscripts.destroy');

   //view manuscript for sub admin
   Route::get('/manuscripts/{id}', [ManuscriptController::class, 'viewManuscripts'])->name('manuscripts.show');
    //approve 
    Route::post('/manuscripts/approve/{id}', [SubController::class, 'approve'])->name('manuscripts.approve');
    
    //Completed Research
    Route::get('/completed-research/create', [SubController::class,'completedIndex'])->name('sub.completed-researchindex');
    //store completed research
    Route::post('/completed-research/store',[CompletedResearchController::class,'store'])->name('comres.store');
    //PUBLICATION 
     Route::get('/publication/create', [SubController::class,'publicationIndex'])->name('sub.publicationindex');
    //store publication
    Route::post('/publications/store', [PublicationController::class, 'store'])->name('exportz.store');
     //utilized research
     Route::get('/utilized-research/create',[SubController::class,'utilizedIndex'])->name('sub.utilizedindex');
    //store utilized research
    Route::post('/utilized-research/store',[UtilizedController::class,'store'])->name('utilized.store');
     //citation
    Route::get('/citation/create',[SubController::class,'citationIndex'])->name('sub.citationindex');
    //store citation
    Route::post('/citations/store',[CitationController::class,'store'])->name('citations.store');
    //Paper presentaiton
    Route::get('/paper-presentation/create',[SubController::class,'paperPresentationIndex'])->name('sub.paper-presentation-index');
    Route::post('/paper-presentation/store',[PresentationController::class,'store'])->name('paper-present.store');
    //Research awards
    Route::get('/research-awards/create',[SubController::class,'researchAwardIndex'])->name('sub.research-awards-index');
    Route::post('/research-award/store',[ResearchAwardController::class,'store'])->name('research-award.store');

    //invention or utility model
    Route::get('/invention-utilitymodel/create',[SubController::class,'inventionUtilityIndex'])->name('sub.invention-utilitymodel-index');
    Route::post('/invention-utility/store',[UtilityController::class,'store'])->name('invention-utility.store');
    
    //dropbox
    Route::get('/my-dropbox',[DropBoxController::class,'index'])->name('dropbox.index');
    Route::delete('/dropbox/delete/{id}', [DropBoxController::class, 'delete'])->name('dropbox.delete');
    Route::post('/dropbox/reupload/{id}', [DropBoxController::class, 'reUpload'])->name('dropbox.reupload');
    //for revision with comment
    Route::post('/drop-report/revise', [DropBoxController::class, 'revise'])->name('drop-report.revise');
    //for approve
    Route::post('/drop-report/approve/{id}', [DropBoxController::class, 'approve'])->name('drop-report.approve');


});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
