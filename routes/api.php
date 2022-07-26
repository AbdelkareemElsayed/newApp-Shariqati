<?php


use App\Http\Controllers\Api\Blogs\blogsController;
use App\Http\Controllers\Api\Events\eventsController;
use App\Http\Controllers\Api\Slider\sliderController;
use App\Http\Controllers\Api\Settings\settingsController;
use App\Http\Controllers\Api\statpages\staticPagesController;
use App\Http\Controllers\Api\Data\dataFilesController;
use App\Http\Controllers\Api\Data\dataController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Branches\branchController;
use App\Http\Controllers\Api\Location\countryController;
use App\Http\Controllers\Api\Location\stateController;
use App\Http\Controllers\Api\Location\cityController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\userController;
use App\Http\Controllers\Api\contctUs\contctUsController;
use App\Http\Controllers\Api\Courses\courses;
use App\Http\Controllers\Api\TeamMembers\teamMembersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\chat\chatController;
use App\Http\Controllers\Api\ecommerceModules\CategoriesController;

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


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',   [AuthController::class, 'login']);
    Route::post('logout',  [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me',      [AuthController::class, 'me']);


    Route::group(['prefix' => 'User'], function () {
        # User Routes . . .
        Route::post('Register', [userController::class, 'Register']);
        Route::get('AccountDetails', [userController::class, 'UserDetails']);
        Route::post('Update', [userController::class, 'UpdateAccount']);
        Route::post('Password/edit', [userController::class, 'updatePassword']);

        # Address . . .
        Route::post('Address/MakeDefault/{id}', [AddressController::class, 'MakeAddressDefault']);
        Route::resource('Address', AddressController::class);

        # CHat . . .
        Route::get('Messages', [chatController::class, 'loadMessages']);
        Route::post('sendMessages', [chatController::class, 'sendMessage']);
    });
});



// Admin URLs
Route::group(['prefix' => 'admin'], function () {
    # Blog Categories
    // Route::get('blogs/categories/{lang}', [categoriesController::class, 'index']);
    // Route::post('blogs/categories/store', [categoriesController::class, 'store']);
    // Route::post('blogs/categories/update/{slug}', [categoriesController::class, 'update']);
    // Route::get('blogs/categories/delete/{slug}', [categoriesController::class, 'destroy']);
    // Route::get('blogs/categories/articles/{slug}/{lang}', [categoriesController::class, 'getCategoryBlogs']);

    # Blogs
    Route::get('blogs/{lang}', [blogsController::class, 'index']);
    Route::post('blogs/store', [blogsController::class, 'store']);
    Route::post('blogs/update/{slug}', [blogsController::class, 'update']);
    Route::get('blogs/delete/{slug}', [blogsController::class, 'destroy']);

    # Slides
    Route::get('slides', [sliderController::class, 'index']);
    Route::post('slides/store', [sliderController::class, 'store']);
    Route::post('slides/update/{id}', [sliderController::class, 'update']);
    Route::get('slides/delete/{id}', [sliderController::class, 'destroy']);

    # Events
    Route::get('events/{lang}', [eventsController::class, 'allEvents']);
    Route::get('events/byDate/{lang}/{date}', [eventsController::class, 'eventsByDate']);
    Route::get('events/bySlug/{lang}/{slug}', [eventsController::class, 'singleEvent']);
    Route::get('events/upcoming/{lang}', [eventsController::class, 'upcomingEvents']);
    Route::get('events/current/{lang}', [eventsController::class, 'currentEvents']);

    # Data
    Route::get('data', [dataController::class, 'index']);
    Route::post('data/store', [dataController::class, 'store']);
    Route::post('data/update/{id}', [dataController::class, 'update']);
    Route::get('data/delete/{id}', [dataController::class, 'destroy']);

    # Files
    Route::get('files/{id}', [dataFilesController::class, 'index']);
    Route::post('files/store', [dataFilesController::class, 'store']);
    Route::get('files/delete/{id}', [dataFilesController::class, 'destroy']);

    # Courses
    Route::get('courses/{lang}', [courses::class, 'index']);
    Route::get('courses/{lang}/{id}', [courses::class, 'single']);

    # Team Members
    Route::get('members/{lang}/{limit}', [teamMembersController::class, 'index']);
    Route::get('members/{lang}/{id}', [teamMembersController::class, 'single']);

    # Settings
    Route::get('settings', [settingsController::class, 'settings']);

    # Helpers
    Route::get('generate-slug', [categoriesController::class, 'generateSlug']);
});


########################################################################################################################
# Location . . .
Route::group(['prefix' => 'Location'], function () {
    # Countries  . . .
    Route::get('Countries', [countryController::class, 'Countries']);

    # States . . .
    Route::get('States/{Country_id}', [stateController::class, 'States']);

    # Cities . . .
    Route::get('Cities/{state_id}', [cityController::class, 'Cities']);
});

########################################################################################################################
# Get Static Pages . . .
Route::apiResource('StaticPages', staticPagesController::class);
########################################################################################################################
# Contact Us . . .
Route::apiResource('ContactUs', contctUsController::class);
########################################################################################################################
# Get Static Pages . . .
Route::apiResource('StaticPages', staticPagesController::class);
########################################################################################################################
# Get Branches . . .
Route::get('Branches/{id}', [branchController::class, 'LoadBranches']);
Route::get('SingleBranch/{id}', [branchController::class, 'SingleBranch']);
########################################################################################################################
Route::post('/store-token', [firebaseController::class, 'storeToken']);
########################################################################################################################

# Ecommerce Modules
Route::get('Categories/{lang}/{limit}', [CategoriesController::class, 'index']);
Route::get('Categories/Subcategories/{category_id}/{limit}', [CategoriesController::class, 'subCategories']);
Route::get('Categories/Products/{category_id}/{limit}', [CategoriesController::class, 'categoryProducts']);
