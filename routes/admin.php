<?php

use App\Http\Controllers\Admins\adminController;
use App\Http\Controllers\Auth\Auth;
use App\Http\Controllers\Blogs\blogsController;
use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Blogs\categoriesController;
use App\Http\Controllers\AdminRoles\RolesController;
use App\Http\Controllers\Branches\branchController;
use App\Http\Controllers\staticPages\staticPagesController;
use App\Http\Controllers\Customers\addressController;
use App\Http\Controllers\Data\accessRequestsController;
use App\Http\Controllers\Data\dataController;
use App\Http\Controllers\Data\dataFilesController;
use App\Http\Controllers\Events\eventsController;
use App\Http\Controllers\Location\citiesController;
use App\Http\Controllers\Location\countriesController;
use App\Http\Controllers\Location\stateController;
use App\Http\Controllers\Languages\languagesController;
use App\Http\Controllers\Notifications\firebaseController;
use App\Http\Controllers\Slider\sliderController;
use App\Http\Controllers\Settings\settingsController;
use App\Http\Controllers\userFiles\userFilesController;
use App\Http\Controllers\contctUs\contctUsController;
use App\Http\Controllers\Courses\coursesController;
use App\Http\Controllers\Courses\courseVideosController;
use App\Http\Controllers\ecommerceModules\manageProductAttributes;
use App\Http\Controllers\ecommerceModules\manageProductAttributesOptions;
use App\Http\Controllers\Files\fileController;
use App\Http\Controllers\Reports\StatisticsController;
use App\Http\Controllers\TeamMmember\teamMembersController;
use App\Models\ecommerceModels\manufactures;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ecommerceModules\ManufacturesController;
use App\Http\Controllers\ecommerceModules\productAttributeOptionsController;
use App\Http\Controllers\ecommerceModules\productAttributesController;
use App\Http\Controllers\ecommerceModules\productImagesController;
use App\Http\Controllers\ecommerceModules\ProductsCategoriesController;
use App\Http\Controllers\ecommerceModules\productsController;
use App\Http\Controllers\businessItems\BusinessItemsController;
use App\Http\Controllers\businessItems\ItemsFlashsaleController;
use App\Http\Controllers\businessItems\microBusinessItemsController;
use App\Http\Controllers\businessItems\subBusinessItemsController;
use App\Models\User;
use  App\Http\Controllers\invoices\invoiceController;


Route::group(['prefix' => 'admin'], function () {


    Route::get('loginApiRedirect', function () {
        return response()->json(['Message' => 'login firts']);
    })->name('loginApi');


    ######################################################################################################################
    # Login Routes . . .
    Route::get('login', [Auth::class, 'login'])->name('login');
    Route::post('doLogin', [Auth::class, 'doLogin'])->name('DoLogin');
    ######################################################################################################################


    Route::group(["middleware" => "admin"], function () {


        ######################################################################################################################
        # Lang Routes . . .
        Route::get('lang/{lang}', function ($lang) {

            ($lang == 'ar') ? session()->put('lang', 'ar') : session()->put('lang', 'en');

            return back();
        });
        ######################################################################################################################
        Route::view('home', 'dashboard.home');

        #######################################################################################################################

        # Admins  Routes . . .
        Route::resource('Admins', adminController::class);


        #######################################################################################################################
        # Admins Roles Routes . . .
        Route::resource('Roles', RolesController::class);

        #######################################################################################################################
        # Admin Profile . . .
        Route::get('Profile', [adminController::class,  "showProfile"]);
        Route::put('Profile/Update/{id}', [adminController::class,  "UpdateProfile"])->middleware('checkProfile');

        #######################################################################################################################
        # Customers . . .
        Route::resource('Customers', CustomerController::class);

        # Customers Address . . .
        Route::get('Customers/Address/{id}', [addressController::class, 'customersAddress']);

        # Address . . .
        Route::resource('Address', addressController::class);



        Route::get('/Customers/Files/{id}', [userFilesController::class, 'index']);
        Route::post('/Customers/File/Download', [userFilesController::class, 'downloadFile']);

        #Customer Files
        Route::resource('/Customer/Files', userFilesController::class);
        #######################################################################################################################

        Route::group(['prefix' => 'Location'], function () {
            # Countries  . . .
            Route::resource('Countries', countriesController::class);

            # Country States . . .
            Route::get('Countries/State/{id}', [stateController::class, 'LoadState']);
            # States . . .
            Route::resource('States', stateController::class);

            #  States City . . .
            Route::get('Countries/States/Cities/{id}', [citiesController::class, 'LoadCities']);

            #  States City  RETURN JSON  . . .
            Route::post('CitiesJSON', [citiesController::class, 'LoadCitiesJSON']);

            # Country States Retun Json
            Route::post('LoadStateJSON', [stateController::class, 'LoadStateJSON']);

            # Cities . . .
            Route::resource('Cities', citiesController::class);
        });
        #######################################################################################################################
        # Business Routes . . .
            Route::resource('BusinessItems', BusinessItemsController::class);

            Route::get('LoadBusinessItemsUnits/{id}', [subBusinessItemsController :: class,'loadISubtems']);

            Route::resource('SubItemsLevel', subBusinessItemsController :: class);



            Route::get('LoadMicroItemsLevel/{id}', [microBusinessItemsController::class,'loadItems']);
            Route::resource('MicroItemsLevel', microBusinessItemsController::class);


        #######################################################################################################################


        Route::get('BusinessItemsFlashsale/{id}', [ItemsFlashsaleController::class,'loadFlashsale']);
        Route::resource('Flashsale', ItemsFlashsaleController::class);
        #######################################################################################################################

        // Route :: get('Invoice',function(){

        //     return view('dashboard.invoice.index');

        // });


        Route :: resource('Invoice',invoiceController::class);

        Route :: get('generate_pdf/{id}',[invoiceController::class,'generate_pdf']);

        Route:: post('checkCustomer',function(){
            return response()->json(['status' => 'success' , 'data' => User :: where('phone',request()->phone)->first()]);
        });

        #######################################################################################################################
        # Static Pages . . .

        Route::resource('StaticPages', staticPagesController::class);

        #######################################################################################################################
        # Contact Us . . .
        Route::resource('ContactUs', contctUsController::class);
        #######################################################################################################################
        # Reports . . .
        Route::get('Report/Statistics/Users/Generate', [StatisticsController::class, 'UserStatistice']);
        Route::get('Report/Statistics/Users', [StatisticsController::class, 'index']);
        #######################################################################################################################
        # Branches . . .
        Route::resource('Branches', branchController::class);
        #######################################################################################################################
        # Files Module . . .
        Route::resource('AccountFiles', fileController::class);

        #######################################################################################################################

        # Blogs and Categories
        Route::resource('Blogs/Categories', categoriesController::class);
        Route::resource('Blogs', blogsController::class);
        Route::get('/generate-slug', [categoriesController::class, 'generateSlug']);
        Route::resource('Slider', sliderController::class);
        #######################################################################################################################
        # Events
        Route::resource('Events', eventsController::class);

        #######################################################################################################################
        # Languages
        Route::resource('Languages', languagesController::class);
        #######################################################################################################################

        # Data
        Route::resource('Data', dataController::class);
        Route::resource('Data/Files', dataFilesController::class);
        Route::get('Files/{id}', [dataFilesController::class, 'index']);
        Route::post('Files/Permissions/{id}', [dataFilesController::class, 'filePermissions']);
        Route::get('RequestAccess/{user_id}/{file_id}', [dataFilesController::class, 'requestAccess']);

        ## Access Requests
        Route::get('AccessRequests', [accessRequestsController::class, 'index']);
        Route::get('AccessRequests/grant/{id}', [accessRequestsController::class, 'grantAccess']);
        Route::get('AccessRequests/reject/{id}', [accessRequestsController::class, 'rejectAccess']);
        #######################################################################################################################
        # Courses
        Route::resource('Courses', coursesController::class);
        Route::resource('Courses/Videos', courseVideosController::class);
        Route::get('Courses/{id}/Videos', [courseVideosController::class, 'index']);


        #######################################################################################################################
        # Team Members
        Route::resource('TeamMembers', teamMembersController::class);
        #######################################################################################################################
        # LogOut . . .
        Route::get('logout',  [Auth::class, 'logout']);
        #######################################################################################################################
        Route::get('Settings', [settingsController::class, 'settingsPage']);
        Route::post('Settings', [settingsController::class, 'updateSettings']);

        Route::fallback(function () {
            return view('dashboard.404');
        });
        #######################################################################################################################


        /*
       ************************************* E-Commerce Routes Modules . . . *************************************
     */

        #######################################################################################################################
        # Manufactures . . .
        Route::resource('Manufactures', ManufacturesController::class);

        Route::resource('Categories', ProductsCategoriesController::class);
        #######################################################################################################################

        # Product Attributes
        Route::resource('Products/Attributes/{attribute_id}/Options', productAttributeOptionsController::class);

        Route::resource('Products/Attributes', productAttributesController::class);

        #######################################################################################################################

        # Products
        Route::get('Products/{product_id}/Images', [productImagesController::class, 'index']);
        Route::resource('Products/Images', productImagesController::class);

        Route::get('Products/{product_id}/ManageAttributes', [manageProductAttributes::class, 'index']);
        Route::resource('Products/ManageAttributes', manageProductAttributes::class);

        Route::get('Products/ManageAttributeOptions/create', [manageProductAttributesOptions::class, 'create']);

        Route::post('Products/ManageAttributeOptions', [manageProductAttributesOptions::class, 'store']);

        Route::delete('Products/ManageAttributeOptions/{option}', [manageProductAttributesOptions::class, 'destroy']);

        Route::get('Products/ManageAttributeOptions/{attribute_id}', [manageProductAttributesOptions::class, 'index']);

        Route::resource('Products', productsController::class);








        // Admin Pannel Route ......
        // Route::resource('admin', [adminController::class]);
        // Route::resource('Customers', [CustomerController::class]);

        //    Route::resource('adminRole','adminRoleController');

        //   // articales ....
        //   Route::resource('articales', 'articalescontroller');
        //   Route::get('articales/Comment/{id}', 'articalescontroller@comments_load');
        //   Route::delete('Comment/destroy/{id}', 'articalescontroller@destroycomment');
        //   Route::delete('removearticales','articalescontroller@destroyAll');
        //   Route::delete('removearticalesComment','articalescontroller@destroyAllcomment');



        //    Route::resource('departments','departmentscontroller');
        //    Route::resource('Modules','modulesController');
        //    Route::get('Modules_active/{id}','modulesController@active');
        //    Route::resource('Gallery', 'galleryController');
        //    Route::resource('staticpages','staticpagescontroller');
        //    Route::resource('Solutions', 'articalescontroller');
        //    Route::resource('Carriers', 'contactuscontroller');
        //    Route::resource('ContactUsForm', 'ContactUsFormcontroller');
        //    Route::resource('Clients', 'clientsController');
        //    Route::resource('AboutUs', 'aboutusController');
        //    Route::resource('Project','projectController');
        //    Route::resource('ClientsDepartments','ClientsDepartmentsController');



        //    Route::get('/', function (){
        //        return view('admin.home');
        //    });
        //    Route::delete('remove','admincontroller@destroyAll');
        //    Route::delete('removeProducts','Productscontroller@destroyAll');
        //    Route::delete('removeModules','modulesController@destroyAll');
        //    Route::delete('removeGallery','galleryController@destroyAll');
        //    Route::delete('removestatic','staticpagescontroller@destroyAll');
        //    Route::delete('removeservices','servicescontroller@destroyAll');
        //    Route::delete('removeCarriers','contactuscontroller@destroyAll');
        //    Route::delete('removecontactsform','ContactUsFormcontroller@destroyAll');
        //    Route::delete('removeProject','projectController@destroyAll');


        //    Route::get('images','imagesController@index');
        //    Route::post('images/fileupload','imagesController@fileupload')->name('images.fileupload');
        //    Route::get('removeImages/{id}','imagesController@dropzoneRemove');
        //    Route::get('images/ImagesSettings','imagesController@getSettings');
        //    Route::put('images/editSettings','imagesController@editSettings');



        //       // SETTINGS ROUTE ......
        //    Route::get('settings', 'SettingsController@setting');
        //    Route::post('settings', 'SettingsController@setting_save');



    });
});

Route::post('/store-token', [firebaseController::class, 'storeToken']);
