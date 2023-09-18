<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\AndonSiteController;
use App\Http\Controllers\Master\DoController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\AndonSystemController;
use App\Http\Controllers\ListConsoleController;
use App\Http\Controllers\Master\LineController;
use App\Http\Controllers\Master\MesinController;
use App\Http\Controllers\StartConsoleController;
use App\Http\Controllers\Master\SpeedLossesController;
use App\Http\Controllers\Master\PlanDownTimesController;
use App\Http\Controllers\Master\QualityLossesController;
use App\Http\Controllers\Master\ScheduleMesinController;
use App\Http\Controllers\Master\UnplanDownTimesController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [StartConsoleController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/full', [AndonSystemController::class, 'full'])->name('andon.full');
Route::get('/site', [AndonSystemController::class, 'site'])->name('andon.site');
Route::get('/oee_historysite', [AndonSiteController::class, 'history_site'])->name('history_site');
Route::get('/start_console', [StartConsoleController::class, 'index'])->name('form.start.console');
Route::get('/list_console', [ListConsoleController::class, 'index'])->name('list.console');
Route::post('/ajax_list', [ListConsoleController::class, 'ajax_list'])->name('ajax.list.console');
Route::post('/store_console', [StartConsoleController::class, 'store'])->name('store.console');
Route::post('/run_schedule', [StartConsoleController::class, 'run_schedule'])->name('run.console');
Route::post('/oee_realtime', [AndonSiteController::class, 'real_time']);
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::post('/ajax_get_mesin', [DataAjaxController::class, 'ajax_get_mesin'])->name('get.mesin');
Route::post('/ajax_get_line', [DataAjaxController::class, 'ajax_get_line'])->name('get.line');
Route::post('/ajax_get_do', [DataAjaxController::class, 'ajax_get_do'])->name('get.do');
Route::post('/ajax_change_mesin', [DataAjaxController::class, 'ajax_change_mesin'])->name('change.mesin');
Route::post('/ajax_finish_mesin', [DataAjaxController::class, 'ajax_finish_mesin'])->name('finish.mesin');
Route::post('/ajax_maintenance_mesin', [DataAjaxController::class, 'ajax_maintenance_mesin'])->name('maintenance.mesin');
Route::post('/ajax_done_repair', [DataAjaxController::class, 'ajax_done_repair'])->name('done.mesin');
Route::post('/ajax_list_maintenance', [DataAjaxController::class, 'ajax_list_maintenance'])->name('all.list.tree');

Route::resource('master/mesin', MesinController::class);
Route::resource('master/line', LineController::class);
Route::resource('master/plan', PlanDownTimesController::class);
Route::resource('master/unplan', UnplanDownTimesController::class);
Route::resource('master/speed_loss', SpeedLossesController::class);
Route::resource('master/quality_loss', QualityLossesController::class);
Route::resource('master/do', DoController::class);
Route::resource('master/sm', ScheduleMesinController::class);

Route::resource('user', UserAccessController::class);
