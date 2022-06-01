<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CompilationsController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Profile\ProfileController;

use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Profile\ProfilePhotoController;

use App\Http\Controllers\Admin\CameraLensesController;
use App\Http\Controllers\Admin\NominationsController;
use App\Http\Controllers\Admin\PhotosController;
use App\Http\Controllers\PhotosController as FrontendPhotosController;
use App\Http\Controllers\CompilationsController as FrontendCompilationsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NominationController;

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

Route::get('/', [HomeController::class, 'index'])->name('frontend');
Route::get('/masonry_test', [HomeController::class, 'masonry_test'])->name('masonry_test');
Route::get('/sel_test', [HomeController::class, 'sel_test'])->name('sel_test');
Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::get('/test2', [HomeController::class, 'test2'])->name('test2');

Route::get('/compilation_with_photos/{slug?}', [FrontendCompilationsController::class, 'compilation_with_photos'])->name('frontend_compilation_with_photos');
Route::get('/get_compilation_with_photos_rows/{compilation_id}/{current_page?}', [FrontendCompilationsController::class, 'get_compilation_with_photos_rows'])->name('get_compilation_with_photos_rows');


Route::get('/photos', [FrontendPhotosController::class, 'photos_without_nominations'])->name('frontend_photos_without_nominations');
Route::get('/get_photos_without_nominations/{current_page?}', [FrontendPhotosController::class, 'get_photos_without_nominations'])->name('get_photos_without_nominations');

Route::get('/photo/{slug}/{photo_source?}', [FrontendPhotosController::class, 'one_photo'])->name('one_photo');

Route::get('/load_one_photo/{photo_id}/{photo_source?}', [FrontendPhotosController::class, 'load_one_photo'])->name('load_one_photo');
Route::post('add_photo_like', [FrontendPhotosController::class, 'add_photo_like'])->name('add_photo_like');
Route::post('add_photo_favorite', [FrontendPhotosController::class, 'add_photo_favorite'])->name('add_photo_favorite');


Route::get('/nominations', [NominationController::class, 'nominations_list'])->name('frontend_nominations_list');
Route::get('/get_nominations_more_rows/{current_page?}', [NominationController::class, 'get_nominations_more_rows'])->name('frontend_get_nominations_more_rows');


Route::get('/nomination/{slug?}/{page?}', [NominationController::class, 'index'])->name('frontend_nomination');
Route::get('/get_nominated_photos/{nomination_id}/{current_page?}', [NominationController::class, 'get_nominated_photos'])->name('frontend_get_nominated_photos');



Route::get('/get_years_selection_array', [HomeController::class, 'get_years_selection_array'])->name('get_years_selection_array');
Route::get('/get_cities_selection_array', [HomeController::class, 'get_cities_selection_array'])->name('get_cities_selection_array');
Route::get('get_all_photos', [HomeController::class, 'get_all_photos'])->name('profile.get_all_photos');

Route::get('get_tags/{active}', [HomeController::class, 'get_tags'])->name('get_tags');

Route::view('/home', 'landing')->name('home');


Route::middleware([ 'auth' ,'verified'])->prefix('admin')->group(function() {
    Route::match(['get', 'post'], '/dashboard', function(){
        return view('dashboard');
    });

    Route::get('/camera_lenses_filter/{page?}', [CameraLensesController::class, 'getFilteredAjax'])->name('CameraLensesGetFilter');
    Route::resource('/camera_lenses', CameraLensesController::class);

    Route::post('/compilations/set_reordering', [CompilationsController::class, 'set_reordering'])->name('CompilationsSetReordering');
    Route::get('/compilations_filter/{page?}', [CompilationsController::class, 'getFilteredAjax'])->name('CompilationsGetFilter');
    Route::resource('/compilations', CompilationsController::class);


    Route::get('/tags_filter/{page?}', [TagsController::class, 'getFilteredAjax'])->name('TagsGetFilter');
    Route::resource('/tags', TagsController::class);

    Route::post('/nominations/set_reordering', [NominationsController::class, 'set_reordering'])->name('NominationsSetReordering');
    Route::get('/nominations_filter/{page?}', [NominationsController::class, 'getFilteredAjax'])->name('NominationsGetFilter');
    Route::resource('/nominations', NominationsController::class);

    Route::get('/get_nomination_photo_covers/{nomination_id?}', [NominationsController::class, 'get_nomination_photo_covers'])->name('GetNominationPhotoCovers');
    Route::post('/photos/assign_to_nomination_photo_covers', [NominationsController::class, 'assign_to_nomination_photo_covers'])->name('photo_assign_to_nomination_photo_covers');
    Route::post('/photos/revoke_from_nomination_photo_covers', [NominationsController::class, 'revoke_from_nomination_photo_covers'])->name('photo_revoke_from_nomination_photo_covers');


    Route::resource('/photos', PhotosController::class);
    Route::get('/new_photos', [PhotosController::class, 'new_photos'])->name('new_photos_filter_index');
    Route::post('/new_photos_filter', [PhotosController::class, 'photos_filter'])->name('new_photos_filter');

    Route::get('/new_photos_filter', [PhotosController::class, 'get_new_photos_filter'])->name('get_new_photos_filter');

    Route::get('/photos_filter', [PhotosController::class, 'index'])->name('photos_filter_index');
    Route::post('/photos_filter', [PhotosController::class, 'photos_filter'])->name('photos_filter');

    Route::get('/get_nominations_for_photo/{photo_id?}', [PhotosController::class, 'get_nominations_for_photo'])->name('GetNominationsPhoto');
    Route::get('/get_compilations_for_photo/{photo_id?}', [PhotosController::class, 'get_compilations_for_photo'])->name('GetCompilationsPhoto');
    Route::get('/get_photo_details/{photo_id?}', [PhotosController::class, 'get_photo_details'])->name('GetPhotoDetails');

    Route::post('/photos/assign_to_nomination', [PhotosController::class, 'assign_to_nomination'])->name('photo_assign_to_nomination');
    Route::post('/photos/revoke_from_nomination', [PhotosController::class, 'revoke_from_nomination'])->name('photo_revoke_from_nomination');
    Route::post('/photos/assign_to_compilation', [PhotosController::class, 'assign_to_compilation'])->name('photo_assign_to_compilation');
    Route::post('/photos/revoke_from_compilation', [PhotosController::class, 'revoke_from_compilation'])->name('photo_revoke_from_compilation');
}); // Route::middleware([ 'auth' ,'verified'])->prefix('admin')->group(function() {


Route::post('/auth/register', [RegisterController::class, 'auth_register'])->name('auth_register');
Route::post('/auth/confirm_code', [RegisterController::class, 'auth_confirm_code'])->name('auth_confirm_code');
Route::post('/auth/completion_registration', [RegisterController::class, 'auth_completion_registration'])->name('auth_completion_registration');
Route::post('/auth/restore_password', [RegisterController::class, 'auth_restore_password'])->name('auth_restore_password');

Route::middleware([ 'auth' ,'verified'])->prefix('profile')->group(function() {

    Route::get('index', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('edit/personal', [ProfileController::class, 'edit'])->name('profile.edit.personal');
    Route::post('update/personal', [ProfileController::class, 'update'])->name('profile.update.personal');

    Route::get('edit/contacts', [ProfileController::class, 'edit_contacts'])->name('profile.edit.contacts');
    Route::post('update/contacts', [ProfileController::class, 'update_contacts'])->name('profile.update.contacts');

    // profile/update/password
    Route::get('edit/password', [ProfileController::class, 'edit_password'])->name('profile.edit.password');
    Route::post('update/password', [ProfileController::class, 'update_password'])->name('profile.update.password');

    Route::get('edit/mailing', [ProfileController::class, 'edit_mailing'])->name('profile.edit.mailing');
    Route::post('update/mailing', [ProfileController::class, 'update_mailing'])->name('profile.update.mailing');

    Route::post('update/avatar', [ProfileController::class, 'update_avatar'])->name('profile.update.avatar');
    Route::delete('delete/avatar', [ProfileController::class, 'delete_avatar'])->name('profile.delete.avatar');

    Route::get('get_photos/{active?}', [ProfilePhotoController::class, 'get_photos'])->name('profile.get_photos');
    Route::get('get_nominated_photos', [ProfilePhotoController::class, 'get_nominated_photos'])->name('profile.get_nominated_photos');

    Route::get('get_free_photos_upload_for_week', [ProfilePhotoController::class, 'get_free_photos_upload_for_week'])->name('profile.get_free_photos_upload_for_week');

    Route::post('upload_photo', [ProfilePhotoController::class, 'upload_photo'])->name('profile.upload_photo');

}); // Route::middleware([ 'auth' ,'verified'])->prefix('profile')->group(function() {


Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
