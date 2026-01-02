<?php

// use App\Http\Controllers\BudgetCalculatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvestmentCalculatorController;
use App\Http\Controllers\RetirementCalculatorController;
use App\Http\Controllers\BudgetCalculatorController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {

    if (Auth::user()->role == "admin") {
        return redirect('admin/dashboard');
    }
    return view('user/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/investment-calculator', [InvestmentCalculatorController::class, 'index'])->name('investment_calculator.index');
Route::post('/investment-calculator', [InvestmentCalculatorController::class, 'calculate'])->name('investment_calculator.calculate');
Route::get('/retirement-calculator', [RetirementCalculatorController::class, 'index'])->name('retirement_calculator.index');
Route::post('/retirement-calculator', [RetirementCalculatorController::class, 'calculate'])->name('retirement_calculator.calculate');
Route::get('/budget', [BudgetCalculatorController::class, 'index'])->name('budget_calculator.index');
Route::get('/mybudgets', [BudgetCalculatorController::class, 'myBudgets'])->name('budget_calculator.list')->middleware(['auth', 'verified']);


Route::get('/budget/{id}/delete', [BudgetCalculatorController::class, 'deleteBudget'])->name('budget_calculator.destroy')->middleware(['auth', 'verified']);
// Route::get('/budget', [BudgetCalculatorController::class, 'index'])->name('budget_calculator.index');
// Route::post('/budget-calculator', [BudgetCalculatorController::class, 'calculate'])->name('budget_calculator.calculate');
Route::get('/budget/{month}/{year}', [BudgetCalculatorController::class, 'showMonthlyBudget'])->name('budget_calculator.show')->middleware(['auth', 'verified']);

Route::post('/save', [BudgetCalculatorController::class, 'store'])->middleware(['auth', 'verified'])->name('budget_calculator.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/blog-posts', [FrontendController::class, 'blogposts'])->name('blog-posts');
Route::get('/blog-details/{id}', [FrontendController::class, 'blogdetails'])->name('blog-details');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
Route::get('/about-us', [FrontendController::class, 'aboutus'])->name('about-us');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
// Route::get('/', function(){ return view('index');})->name('index');

// ADMIN DASHBOARD ROUTES
Route::resource('admin/blog', BlogController::class)->middleware(['auth', 'verified', Admin::class])->names('blogs');
Route::resource('admin/user', UserController::class)->middleware(['auth', 'verified', Admin::class])->names('users');
Route::post('contact/store', [FrontendController::class, 'contactus'])->name('contact.us');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified', Admin::class])->name('admin-dashboard');
Route::resource('/admin/dashboard/youtube', YoutubeController::class)->middleware(['auth', 'verified', Admin::class])->names('youtube.index')->names(['youtube']);


Route::resource('course', CourseController::class)->middleware(['auth', 'verified',]);
Route::resource('lesson', LessonController::class)->middleware(['auth', 'verified',]);
Route::get('{course}/add/lesson', [LessonController::class, 'create'])->middleware(['auth', 'verified',])->name('create.lesson');
Route::get('add/contact', [AdminController::class, 'contacts'])->middleware(['auth', 'verified',])->name('contact.index');
// Route::post('{course_id}/lesson/store{', [LessonController::class, 'store' ])->middleware(['auth', 'verified',])->name('lesson.add');
Route::resource('course/register', CourseRegistrationController::class)->middleware(['auth', 'verified'])->names('course.register');
Route::get('mycourses', [CourseRegistrationController::class, 'mycourses'])->middleware(['auth', 'verified'])->name('mycourses');


// USER DASHBOARD ROUTES
use App\Http\Controllers\MortgageCalculatorController;
use App\Http\Controllers\MortgagePayoffController;

Route::get('/mortgage-calculator', [MortgageCalculatorController::class, 'index'])->name('mortgage-calculator');
Route::post('/calculate-mortgage', [MortgageCalculatorController::class, 'calculate'])->name('calculate-mortgage');
Route::get('/tax-filing', function () { return view('tax-filing');});
Route::get('/mortgage-payoff', [MortgagePayoffController::class, 'index'])->name('mortgage.payoff');
Route::post('/mortgage-payoff', [MortgagePayoffController::class, 'calculate'])->name('mortgage.calculate');

// Financial Assessment Routes
use App\Http\Controllers\FinancialAssessmentController;
Route::get('/financial-assessment', [FinancialAssessmentController::class, 'index'])->name('financial-assessment.index');
Route::post('/financial-assessment', [FinancialAssessmentController::class, 'store'])->name('financial-assessment.store');
Route::get('/financial-assessment/{id}/result', [FinancialAssessmentController::class, 'result'])->name('financial-assessment.result');

// Newsletter Routes
use App\Http\Controllers\NewsletterController;
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Success Stories Routes
use App\Http\Controllers\SuccessStoryController;
Route::get('/success-stories', [SuccessStoryController::class, 'index'])->name('success-stories.index');
Route::get('/success-stories/{id}', [SuccessStoryController::class, 'show'])->name('success-stories.show');

// New Calculator Routes
use App\Http\Controllers\DebtSnowballCalculatorController;
use App\Http\Controllers\NetWorthCalculatorController;
use App\Http\Controllers\CompoundInterestCalculatorController;
Route::get('/debt-snowball-calculator', [DebtSnowballCalculatorController::class, 'index'])->name('debt-snowball-calculator.index');
Route::get('/net-worth-calculator', [NetWorthCalculatorController::class, 'index'])->name('net-worth-calculator.index');
Route::get('/compound-interest-calculator', [CompoundInterestCalculatorController::class, 'index'])->name('compound-interest-calculator.index');

// Financial Milestones Routes
use App\Http\Controllers\FinancialMilestoneController;
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/financial-milestones', [FinancialMilestoneController::class, 'index'])->name('financial-milestones.index');
    Route::post('/financial-milestones', [FinancialMilestoneController::class, 'store'])->name('financial-milestones.store');
    Route::patch('/financial-milestones/{id}', [FinancialMilestoneController::class, 'update'])->name('financial-milestones.update');
    Route::delete('/financial-milestones/{id}', [FinancialMilestoneController::class, 'destroy'])->name('financial-milestones.destroy');
});

// Financial Coaching Routes
use App\Http\Controllers\FinancialCoachingController;
Route::get('/financial-coaching', [FinancialCoachingController::class, 'index'])->name('financial-coaching.index');
Route::post('/financial-coaching', [FinancialCoachingController::class, 'store'])->name('financial-coaching.store');

// Blog Notification Routes
use App\Http\Controllers\BlogNotificationController;
Route::post('/blog-notifications/subscribe', [BlogNotificationController::class, 'subscribe'])->name('blog-notifications.subscribe');
Route::post('/blog-notifications/unsubscribe', [BlogNotificationController::class, 'unsubscribe'])->name('blog-notifications.unsubscribe');
Route::get('/admin/blog-notifications', [BlogNotificationController::class, 'index'])->middleware(['auth', 'verified', Admin::class])->name('admin.blog-notifications.index');

// Multi-Channel Notification Routes
use App\Http\Controllers\NotificationController;
Route::get('/admin/notifications/create', [NotificationController::class, 'create'])->middleware(['auth', 'verified', Admin::class])->name('admin.notifications.create');
Route::post('/admin/notifications/send', [NotificationController::class, 'send'])->middleware(['auth', 'verified', Admin::class])->name('admin.notifications.send');
