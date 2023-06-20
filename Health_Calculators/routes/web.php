<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BMICalculatorController;
use App\Http\Controllers\DailyCalorieController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\MealCalculatorController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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
// ---------------------------------------------------------------------------------
//Test Routes
// Route::get('test',[TestController::class,'test']);
// Route::get('test','TestController@test');
//Views Routes
// Route::view('patient/signup', 'Patient.sign-up')->name('patient.signup');
// Route::view('doctor/signup', 'Doctor.sign-up')->name('doctor.signup');
// Route::view('log-in', 'login')->name('auth.login');
// Route::view('dr/details', 'Admin.doctordetails')->name('doctor.details');
// Route::view('dr/requests', 'Admin.doctorrequests');
// Route::view('profile', 'Admin.profile');
// Route::get('profile/{id}', [AdminController::class, 'ShowDoctorDetails']);
// Route::view('patient/profile', 'Patient.profile')->name('pp')->middleware('AllLoginCheck');
// Route::view('doctor/profile', 'Doctor.profile')->name('dd')->middleware('AllLoginCheck');
// Route::get('mmm/test', [LoginController::class, 'test']);
// Route::view('edit', "Admin.editprofile")->name('profile.edit');
// Route::view('edit', "Admin.editprofile")->name('profile.edit');
// Route::view('question', "Patient.question");
// Route::view('result', "result")->name('search_doctors');
// Route::view('/', "home")->name('home.page');
// Route::view('articles', 'articles')->name('articles');
// Route::view('articles', 'article')->name('all.articles');
// Route::view('editt','Admin.editarticles');
// Route::get('edit/article/{id}', [ArticleController::class, 'EditArticle'])->name('edit.article');
// Route::post('update/article/{id}', [ArticleController::class, 'UpdateArticle'])->name('update.article');
// Route::get('/', function () {
//     return view('welcome');
// })->name('home.page');
// Route::view('not', 'notifications');
// Route::view('art', 'viewarticle');
// Route::get('noo', [NotificationsController::class, 'GetNewNotifications']);
// Route::get('', [NotificationsController::class, 'GetNewNotifications']);
// Route::view('testt','Shared.left-container');
// Route::view('appointment', 'Patient.appointment')->name('appointment');
// Route::view('digital', 'Doctor.add-prescription');
// Route::view('all', 'Patient.all-prescriptions');
// Route::view('dp', 'Patient.digital-prescription');
// Route::view('edit/pre', 'Doctor.edit-prescription');
// Route::view('meal', 'Patient.meal-calories');
Route::view('card', 'Admin.dr-visit-card');
// ------------------------------------------------------------------------------------------------------------------



//Patient Routes
Route::get('patient/sign-up', [PatientController::class, 'RegisterAsPatient'])->name('patient.signup');
Route::post('patient/save', [PatientController::class, 'SavePatient'])->name('patient.save');
Route::get('patient/profile', [PatientController::class, 'OpenPatientProfile'])->name('patient.profile')->middleware('Patient_LoginChecks');
Route::get('question', [QuestionController::class, 'AskQuestion'])->name('question');
Route::get('question', [QuestionController::class, 'AllQuestions'])->name('all.question');
Route::post('question/save', [QuestionController::class, 'SaveQuestion'])->name('question.save');
Route::post('question/reply/{id}', [QuestionController::class, 'PatientReply'])->name('patient.reply');
Route::get('cancel/app/{id}', [PatientController::class, 'CancelAppointment'])->name('cancel.app');
Route::post('rate/doctor/{id}', [PatientController::class, 'RateDoctor'])->name('rate.doctor');
Route::get('all/prescriptions', [PatientController::class, 'ViewPatientPrescriptions'])->name('all.patient.prescriptions')->middleware('Patient_LoginChecks');
Route::get('view/prescription/{p_id}', [PatientController::class, 'ViewPrescription'])->name('view.prescription')->middleware('Patient_LoginChecks');
Route::get('meal/calculator', [MealCalculatorController::class, 'ShowMealCalculator'])->name('meal.calculator')->middleware('OpenDrProfile');
Route::post('meal/name', [MealCalculatorController::class, 'GetMealImage'])->name('get.meal.name');
Route::get('daily/calculator', [DailyCalorieController::class, 'GetDailyCalculator'])->name('daily.calculator')->middleware('OpenDrProfile');
Route::post('daily/result', [DailyCalorieController::class, 'CalculateDailyCalories'])->name('daily.calories');
Route::get('bmi/calculator', [BMICalculatorController::class, 'ShowBMICalculator'])->name('bmi.calculator')->middleware('OpenDrProfile');
Route::post('bmi/result', [BMICalculatorController::class, 'CalculateBMI'])->name('bmi.result');

//Doctor Routes
Route::get('doctor/sign-up', [DoctorController::class, 'registerAsDoctor'])->name('doctor.signup');
Route::post('doctor/save', [DoctorController::class, 'saveRequest'])->name('doctor.save');
Route::get('mail',[AdminController::class,'SendMail'])->name('doctor.wait')->middleware('Doctor_LoginChecks');
Route::post('answer/question/{id}', [QuestionController::class, 'AnswerQuestion'])->name('answer.question');
Route::get('drprofile', [DoctorController::class, 'DrProfile'])->name('drprofile')->middleware('Doctor_LoginChecks');
Route::post('drprofile/bio/save', [DoctorController::class, 'AboutDoctor'])->name('save.bio');
Route::post('drprofile/fixedtime/save', [DoctorController::class, 'FixedWorkingTime'])->name('save.fixedtime');
Route::post('drprofile/flexibletime/save', [DoctorController::class, 'FlexibleWorkingTime'])->name('save.flexibletime');
Route::get('dr/profile/appointment/{id}/{c_id}', [DoctorController::class, 'DrAppointments'])->name('appointment');
Route::post('delete/appointment/{id}', [DoctorController::class, 'DeleteAppointment'])->name('del.app');//
Route::post('detailed/clinic/address', [DoctorController::class, 'AddDetailedClinicAddress'])->name('detailed.clinic.address');
Route::get('add/prescription/{patient_app_id}', [DoctorController::class, 'AddPrescription'])->name('add.prescription');
Route::post('save/prescription/{app_id}', [DoctorController::class, 'SavePrescription'])->name('save.prescription');
Route::get('edit/prescription/{app_id}', [DoctorController::class, 'EditPrescription'])->name('edit.prescription');
Route::post('update/prescription/{pre_id}', [DoctorController::class, 'UpdatePrescription'])->name('update.prescription');
Route::get('patients/list', [DoctorController::class, 'GetAllPatients'])->name('all.patients');


//Login Routes
// Route::get('login',[LoginController::class, 'MultiLogin'])->name('all.login')->middleware('AllLoginCheck');
Route::get('login/{requestUri?}',[LoginController::class, 'MultiLogin'])->name('all.login')->middleware('AllLoginCheck');
Route::post('login/check',[LoginController::class, 'MultiLoginCheck'])->name('all.login.check');


//Logout Routes
Route::get('logout', [LoginController::class, 'MultiLogout'])->name('all.logout');


//Admin Routes
Route::post('delete/doctor/{id}', [AdminController::class, 'DeleteDoctor'])->name('doctor.delete');
Route::post('add/article/save',[ArticleController::class, 'AddArticle'])->name('add.article');
Route::get('del/question/{id}', [QuestionController::class, 'DeleteQuestion'])->name('del.question');
Route::get('del/answer/{id}', [QuestionController::class, 'DeleteAnswer'])->name('del.answer');
Route::get('del/article/{id}', [ArticleController::class, 'DeleteArticle'])->name('del.article');
Route::get('all/doctors/detials/{id}', [AdminController::class, 'allDoctorDetails'])->name('all.dr.details');
Route::get('show/doctor/details/{id}', [AdminController::class, 'ShowDoctorDetails'])->name('doctor.details');

//Middleware: Protected Routes From Admin
Route::group(['middleware'=>['AllLoginCheck']], function() {
    Route::get('all/doctors', [AdminController::class, 'ShowAllDoctors'])->name('all.dr');
    Route::get('show/doctor/requests', [AdminController::class, 'ShowDoctorRequests'])->name('doctor.request');
    Route::get('doctor/accept/{id}', [AdminController::class, 'AccecptDoctor'])->name('doctor.accept');
    Route::post('doctor/reject/{id}', [AdminController::class, 'RejectDoctor'])->name('doctor.reject');
    Route::post('update/article/{id}', [ArticleController::class, 'UpdateArticle'])->name('update.article');
});



//Public Routes
Route::get('/', [HomeController::class, 'ShowHome'])->name('home.page');
Route::post('/', [HomeController::class, 'GetQuestion'])->name('get.question');
Route::view('all/notifications', 'Public-Views.notifications')->name('all.notifications')->middleware('AllLoginCheck');
Route::any('all/articles', [ArticleController::class, 'ShowAllArticles'])->name('all.articles');
Route::get('article/{id}', [ArticleController::class, 'ReadArticle'])->name('read.article');

//Maryam Routes
Route::get('edit', [EditController::class,'showdata'])->name('profile.edit')->middleware('AllLoginCheck');
Route::post('update/{id}',[EditController::class,'update'])->name('user.update');
Route::post('bookappointment/{id}',[PatientController::class,'BookAppointment'])->name('patient.bookappointment');
Route:: get('remove/{id}', [EditController::class, 'DeletePhoto'])->name('remove.photo');//


//Menna Routes
Route::any('doctors/search', [SearchController::class, 'Search'])->name('search_doctors');
Route::get('search/doctor/profile/{id}', [DoctorController::class, 'DrVisit'])->name('get_doctor_profile')->middleware('OpenDrProfile');
Route::get('search/governement/{gov}]', [SearchController::class, 'SearchGov'])->name('search_gov');
Route::get('search/cities/{city}/{gov}]', [SearchController::class, 'SearchCity'])->name('search_city');


//Nasser Routes
Route::controller(PaymentController::class)->group(function(){
    // Route::get('/check','Index')->name('paymentindex');
    Route::get('/request-payment/{fees}','RequestPayment')->name('requestpayment');
    Route::get('/payment-success','PaymentSuccess')->name('paymentsuccess');
    Route::get('/payment-Cancel','PaymentCancel')->name('paymentcancel');
});


// <nV7N_Ce
//sb-w12qn25838329@personal.example.com
