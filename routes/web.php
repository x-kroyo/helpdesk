<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TicketController;

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

/**
 * Setup routes
 * This is responsible for setting up the application by
 * creating an admin user if no user exists.
 */
Route::prefix('set-up')->middleware('setup.done')->name('setup.')->group(function () {
    Route::get('', [ SetupController::class, 'create' ])->name('create');
    Route::post('', [ SetupController::class, 'store' ])->name('store');
});

Route::middleware('setup.need')->group(function () {

    /**
     * Users routes
     * This routes are responsable for user management including authentication,
     * account creation (stored as client) and logout process
     * Log in and sign up uses require the user to don't be authentified
     * While log out process needs the users to be authentified => 'auth' middlware
     */
    Route::name('user.')->group(function () {

        Route::prefix('login')->group(function () {
            Route::get('', [ UserController::class, 'login' ])->name('login');
            Route::post('', [ UserController::class, 'authenticate' ])->name('auth');
        });
        Route::prefix('sign-up')->group(function () {
            Route::get('', [ UserController::class, 'create' ])->name('create');
            Route::post('', [ UserController::class, 'store'])->name('store');
        });
        Route::get('logout', [ UserController::class, 'logout' ])->name('logout')->middleware('auth');
    });

    /**
     * This routes are responsable for user email confirmations
     */
    Route::prefix('email')->middleware('auth')->name('verification.')->group(function () {
        Route::get('verify/{id}/{hash}', [ EmailController::class, 'verify' ])->name('verify');
        Route::get('resend-verification', [ EmailController::class, 'resend' ])->name('send');
    });

    /**
     *
     *
     */
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/', function () { return view('dashboard.home.index'); })->name('index');

        Route::prefix('roles')->name('role.')->group(function () {

            Route::get('/', [ RoleController::class, 'index' ])->name('index');
            Route::get('add', [ RoleController::class, 'create' ])->name('create');
            Route::post('add', [ RoleController::class, 'store' ])->name('store');
            Route::get('edit/{id}', [ RoleController::class, 'edit' ])->name('edit');
            Route::post('edit/{id}', [ RoleController::class, 'update' ])->name('update');
            Route::get('delete/{id}', [ RoleController::class, 'delete' ])->name('delete');
            Route::get('/{id}', [ RoleController::class, 'view' ])->name('view');

    });

    });



    /**
     *
     *  les routes des clients
     *
     */
        Route::prefix('dashboard')->name('dashboard.')->group(function(){

            Route::prefix('customers')->name('customers.')->group(function(){

                Route::get('/',[ClientController::class, 'index'])->name('index');
                Route::get('add',[ClientController::class, 'create' ])->name('create');
                Route::post('add',[ClientController::class, 'store' ])->name('store');
                Route::get('edit/{id}',[ClientController::class, 'edit' ])->name('edit');
                Route::put('edit/{id}',[ClientController::class, 'update' ])->name('update');

                Route::delete('delete/{id}',[ClientController::class, 'destroy' ])->name('destroy');


                Route::put('block/{id}',[ClientController::class, 'block' ])->name('block');
                Route::put('deblock/{id}',[ClientController::class, 'deblock' ])->name('deblock');

                Route::get('confirm-block/{id}',[ClientController::class, 'confirmBlock' ])->name('confirm-block');

                Route::get('confirm-supprimer/{id}',[ClientController::class, 'confimSupprimer' ])->name('confirm-supprimer');

            });

        });

        /**
         *
         *     les routes de la vérification du comptes des clients
         *
         */
            Route::get('/verify_email/{hash}',[ClientController::class, 'verifyEmail']);
            Route::get('editPassword/{hash}',[ClientController::class, 'editPassword'])->name('editPassword');
            Route::put('editPassword/{hash}',[ClientController::class, 'updatePassword'])->name('updatePassword');


        /**
         *
         *     la création d'un ticket avec AJax
         *
         */

        Route::post('/check-email', [TicketController::class, 'checkEmail']);




    /**
     *    les routes de l'horaire
     *
     */

    Route::prefix('dashboard')->name('dashboard.')->group(function(){


    Route::get('/calendar',[CalendarController::class,'calendar'])->name("calendar");
    Route::get('/newCalendar',[CalendarController::class,'newCalendar'])->name("newCalendar");
    Route::get('calendar/edit/{id}', [ CalendarController::class,'edit'])->name('edit');
    Route::put('/calendar/{id}',[ CalendarController::class,'update'])->name('update');


        // consulter les horaires
    Route::get('/consulter/{id}',[ CalendarController::class,'consulter'])->name('consulter');


    Route::delete('/calendar/{id}', [ CalendarController::class,'destroy'])->name('calendar.destroy');

    Route::get('add',[CalendarController::class,'create'])->name("create");
    Route::post('add',[CalendarController::class,'store1'])->name("store1");

    Route::get('/test',[CalendarController::class,'testHoraire'])->name("test");
    });
    /**
     *
     *
     */

    Route::get('/',[StaticController::class,'accueil'])->name("home.accueil");
    Route::get('home',[StaticController::class,'home'])->name("home.home");
    Route::get('knowldege_base',[StaticController::class,'knowldege'])->name("home.base");
    Route::get('new_ticket',[StaticController::class,'new_ticket'])->name("new_ticket");
    Route::get('navbar',[StaticController::class,'navbar'])->name("navbar");

    Route::post('check_email', [TicketController::class, 'newTicket'])->name('newTicket');
    Route::post('/new_ticket', [TicketController::class, 'newTicket'])->name('newTicket');

// Route::post('/checkEmail', [TicketController::class, 'checkEmail'])->name('checkEmail');
// Route::post('/newTicket', [TicketController::class ,'newTicket'])->name('newTicket');
});


/**
 *
 *  Consulter les agent
 *
 */
Route::prefix('dashboard')->name('dashboard.')->group(function(){


Route::get('/consultAgent',[AgentController::class,'consultAgent'])->name('consultAgent');

});
/**
 *
 *  les sections
 *
 */

            Route::prefix('dashboard')->name('dashboard.')->group(function(){

                Route::prefix('section')->name('section.')->group(function(){

                    Route::get('/', [SectionController::class, 'index'])->name('index');
                    Route::post('/', [SectionController::class, 'store'])->name('store');

                    Route::get('edit/{id}', [SectionController::class, 'edit'])->name('edit');
                    Route::put('update/{id}', [SectionController::class, 'update'])->name('update');

                    Route::get('destory/{id}',[SectionController::class, 'destroy'])->name('destroy');

                });

            });
            Route::prefix('dashboard')->name('dashboard.')->group(function(){

                Route::prefix('category')->name('category.')->group(function(){

                    Route::get('/', [CategoryController::class, 'index'])->name('index');
                    Route::post('/', [CategoryController::class, 'store'])->name('store');

                    Route::get('delete/{id}',[CategoryController::class, 'destroy'])->name('delete');
                    Route::get('.edit/{id}',[CategoryController::class, 'edit'])->name('edit');
                    Route::put('edit/{id}',[CategoryController::class, 'update'])->name('update');


                });

            });

            Route::prefix('tickets')->name('tickets.')->group(function(){

                Route::get('/', [TicketController::class, 'ticket'])->name('tickets');
                // Route::POST('search', [TicketController::class, 'search'])->name('search');
                Route::match(['get', 'post'], 'search', [TicketController::class, 'search_ticket'])->name('search_ticket');
                Route::get('NotFound', [TicketController::class, 'notfound'])->name('notfound');

                Route::get('myticket', [TicketController::class, 'show1'])->name('show1');
                Route::get('responses/{id}', [TicketController::class, 'response'])->name('response');

                Route::get('feedback', [FeedbackController::class, 'feedback'])->name('feedback');
                Route::post('feedback', [FeedbackController::class, 'feed'])->name('feed');

                // Route::get('response', [MessageController::class, 'index'])->name('index');
                Route::POST('response/{id}', [MessageController::class, 'store'])->name('store');

                Route::get('destroy/{id_message}', [MessageController::class, 'destroy'])->name('destroy');

                Route::get('chercher', [TicketController::class, 'chercher'])->name('chercher');

                Route::get('search-articles', [ArticleController::class, 'search'])->name('search');
                Route::post('result-articles', [ArticleController::class, 'show'])->name('show');

                Route::get('article/{id}', [ArticleController::class, 'article'])->name('article');
                // Route::get('liste-article/{category_id}/article/{article_id}', [ArticleController::class, 'article'])->name('article');

            });
            Route::prefix('helpdesk')->name('helpdesk.')->group(function(){

                Route::get('io', [SectionController::class, 'section'])->name('section');

                Route::get('liste-article/{id}', [SectionController::class, 'liste'])->name('liste-article');

                Route::get('liste-article/{category_id}/article/{article_id}', [SectionController::class, 'show'])->name('show-article');

            });


            // language
            Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => '\App\Http\Controllers\LanguagesController@switchLang']);





