<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\EventLikeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EventCalendarController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Аутентификация
Auth::routes(['verify' => true]);

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/load-more-events', [HomeController::class, 'loadMoreEvents'])->name('events.load-more');

// Маршруты для мероприятий
Route::get('/events/create', [EventController::class, 'create'])->name('events.create')->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->name('events.store')->middleware('auth');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit')->middleware('auth');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update')->middleware('auth');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('auth');

// Лайки мероприятий
Route::post('/events/{event}/like', [EventController::class, 'like'])->name('events.like')->middleware('auth');
Route::delete('/events/{event}/unlike', [EventController::class, 'unlike'])->name('events.unlike')->middleware('auth');

// Комментарии
Route::post('/events/{event}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/comments/{comment}/replies', [CommentReplyController::class, 'store'])->name('replies.store')->middleware('auth');

// Поиск
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/search', [SearchController::class, 'search'])->name('search.results');

// Категории
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Профиль пользователя
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    // Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.settings');
    Route::post('/profile/settings', [ProfileController::class, 'update'])->name('profile.settings.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
});

// Просмотр профиля пользователя
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Статические страницы
Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/contacts', function() {
    return view('contacts');
})->name('contacts');

Route::post('/users/{user}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Запись на мероприятие
Route::post('/events/{event}/participate', [EventController::class, 'participate'])->middleware('auth')->name('events.participate');

Route::get('/event-dates', [EventCalendarController::class, 'getEventDates']);
Route::get('/events-by-date', [EventCalendarController::class, 'getEventsByDate']);

// Админ-панель
Route::get('/admin', function() {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Админка
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}', [\App\Http\Controllers\AdminUserController::class, 'show'])->name('users.show');
    Route::get('/events', [\App\Http\Controllers\AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\AdminEventController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\AdminEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [\App\Http\Controllers\AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}', [\App\Http\Controllers\AdminEventController::class, 'show'])->name('events.show');
    Route::get('/categories', [\App\Http\Controllers\AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [\App\Http\Controllers\AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [\App\Http\Controllers\AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/categories/{category}', [\App\Http\Controllers\AdminCategoryController::class, 'show'])->name('categories.show');
    Route::get('/messages', [\App\Http\Controllers\AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [\App\Http\Controllers\AdminMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [\App\Http\Controllers\AdminMessageController::class, 'destroy'])->name('messages.destroy');
});

Route::post('/contacts', [\App\Http\Controllers\ContactMessageController::class, 'store'])->name('contacts.send');

