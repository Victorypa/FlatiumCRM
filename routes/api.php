<?php

use Illuminate\Http\Request;

    /**
     * Authentication
    */
    Route::group(['namespace' => 'Api\Auth', 'prefix' => 'auth'], function ($router) {
        Route::post('login', 'UserController@login')->name('login');
        Route::post('logout', 'UserController@logout');
        Route::post('refresh', 'UserController@refresh');
        Route::post('me', 'UserController@me');
    });

    /**
     * Orders
    */
    Route::group(['prefix' => 'orders', 'namespace' => 'Api\Orders', 'middleware' => 'admin'], function ($router) {
        Route::get('/', 'OrderController@index');
        Route::get('/{order}', 'OrderController@show');
        Route::get('/{order}/copy', 'OrderController@copy');
        Route::patch('/{order}/update', 'OrderController@update');
        Route::delete('/{order}/destroy', 'OrderController@destroy');
        Route::patch('/{order}/discount_or_markup/update', 'OrderController@updateOrderDiscountOrMarkup');

        /**
         * Financial
        */
        Route::group(['namespace' => 'Financial'], function ($router) {
            Route::post('/{order}/finance/store', 'FinanceController@store');
            Route::delete('/{order}/finance/{finance}/delete', 'FinanceController@destroy');
        });

        /**
         * Order Steps
        */
        Route::group(['namespace' => 'Steps'], function () {
            Route::get('/{order}/order_steps', 'OrderStepController@index');
            Route::get('/{order}/order_step/{order_step}/show', 'OrderStepController@show');
            Route::patch('/{order}/order_step/{order_step}/update', 'OrderStepController@update');
            Route::post('/{order}/order_step/store', 'OrderStepController@store');
            Route::delete('/{order}/order_step/{order_step}/destroy', 'OrderStepController@destroy');

            /**
             * Room Steps - Services
            */
            Route::group(['namespace' => 'RoomSteps\Services'], function () {
                Route::get('/{order}/order_steps/{order_step}/services', 'RoomStepServiceController@index');
                Route::post('/{order}/order_steps/{order_step}/services/store', 'RoomStepServiceController@store');
                Route::post('/{order}/room_steps/{room_step}/services/{service}/detach', 'RoomStepServiceController@destroy');
            });


        });

        /**
         * Orders Exports
        */
        Route::group(['prefix' => '/{order}/export'], function ($router) {
            Route::get('/pdf', 'OrderController@exportPdfWithoutMaterials');
            Route::get('/pdf/materials', 'OrderController@exportPdfWithMaterials');

            Route::get('/excel', 'OrderController@exportExcelWithoutMaterials');
            Route::get('/excel/materials', 'OrderController@exportExcelWithMaterials');
        });

        /**
         * Finshed Order Act
        */
        Route::group(['namespace' => 'Acts'], function ($router) {
            Route::get('/{order}/finished_order_act/{finished_order_act}/show', 'FinishedOrderActController@show');
            Route::patch('/{order}/finished_order_act/{finished_order_act}/update', 'FinishedOrderActController@update');
            Route::post('/{order}/finished_order_act/store', 'FinishedOrderActController@store');
            Route::delete('/{order}/finished_order_act/{finished_order_act}/destroy', 'FinishedOrderActController@destroy');

            /**
             * Finished Order Acts Exports
            */
            Route::group(['prefix' => '/{order}/finished_order_act/{finished_order_act}'], function () {
                Route::get('/export/pdf', 'FinishedOrderActController@exportPdf');
            });

            /**
             * Finished Rooms - FinishedServices
            */
            Route::group(['namespace' => 'Rooms\Services'], function () {
                Route::get('/{order}/finished_order_act/{finished_order_act}/finished_room/{finished_room}/services', 'FinishedRoomServiceController@index');
                Route::post('/{order}/finished_order_act/{finished_order_act}/services/store', 'FinishedRoomServiceController@store');
            });

        });

        /**
         * Extra Order Act
        */
        Route::group(['namespace' => 'Acts'], function () {
            Route::get('/{order}/extra_order_act/{extra_order_act}', 'ExtraOrderActController@show');
            Route::patch('/{order}/extra_order_act/{extra_order_act}/update', 'ExtraOrderActController@update');
            Route::post('/{order}/extra_order_act/store', 'ExtraOrderActController@store');
            Route::delete('/{order}/extra_order_act/{extra_order_act}/destroy', 'ExtraOrderActController@destroy');

            /**
             * Extra Order Act Export
            */
            Route::get('/{order}/extra_order_act/{extra_order_act}/export/pdf', 'ExtraOrderActController@exportWithoutMaterials');
            Route::get('/{order}/extra_order_act/{extra_order_act}/export/pdf/materials', 'ExtraOrderActController@exportPDFWithMaterials');


            /**
             * Extra Rooms
            */
            Route::group(['namespace' => 'Rooms'], function () {
                Route::get('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}', 'ExtraRoomController@show');

                /**
                 * Extra Rooms - Extra Windows
                */
                Route::group(['namespace' => 'ExtraWindows'], function () {
                    Route::get('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_windows', 'ExtraRoomExtraWindowController@index');
                    Route::post('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_windows/store', 'ExtraRoomExtraWindowController@store');
                    Route::patch('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_windows/{extra_room_window}/update', 'ExtraRoomExtraWindowController@update');
                    Route::delete('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_windows/{extra_room_window}/delete', 'ExtraRoomExtraWindowController@destroy');
                });

                /**
                 * Extra Rooms - Extra Services
                */
                Route::group(['namespace' => 'Services'], function () {
                    Route::get('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_services', 'ExtraRoomServiceController@index');
                    Route::post('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/extra_services/store', 'ExtraRoomServiceController@store');

                    /**
                     * Extra Room Service -  Materials
                    */
                    Route::group(['namespace' => 'Materials'], function () {
                        Route::get('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/services/{service}/materials', 'ExtraRoomServiceMaterialController@index');
                        Route::post('/{order}/extra_order_act/{extra_order_act}/extra_rooms/{extra_room}/services/{service}/materials/store', 'ExtraRoomServiceMaterialController@store');
                    });

                });
            });
        });


        /**
         * Rooms
        */
        Route::group(['namespace' => 'Rooms'], function () {

            Route::get('/{order}/rooms/{room}', 'RoomController@show');
            Route::post('/{order}/rooms/create', 'RoomController@store');
            Route::patch('/{order}/rooms/{room}/update', 'RoomController@update');
            Route::patch('/{order}/rooms/{room}/update_description', 'RoomController@updateDescription');
            Route::delete('/{order}/rooms/{room}/destroy', 'RoomController@destroy');

            /**
             * Rooms - Services
            */
            Route::group(['namespace' => 'Services'], function () {
                Route::get('/{order}/rooms/{room}/services', 'RoomServiceController@index');
                Route::get('/{order}/rooms/{room}/services/{service}/show', 'RoomServiceController@show');
                Route::post('/{order}/rooms/{room}/services/store', 'RoomServiceController@store');

                /**
                 * Rooms - Services - Materials
                */
                Route::group(['namespace' => 'Materials'], function () {
                    Route::get('/{order}/rooms/{room}/services/{service}/materials', 'RoomServiceMaterialController@index');
                    // Route::get('/{order}/rooms/{room}/services/{service}/materials/search', 'RoomServiceMaterialController@search');
                    Route::post('/{order}/rooms/{room}/services/{service}/materials/store', 'RoomServiceMaterialController@store');
                });
            });

            /**
             * Room - Windows
            */
            Route::group(['namespace' => 'Windows'], function () {
                Route::get('/{order}/rooms/{room}/windows', 'RoomWindowController@index');
                Route::post('/{order}/rooms/{room}/window/store', 'RoomWindowController@store');
                Route::patch('/{order}/rooms/{room}/windows/{window}/update', 'RoomWindowController@update');
                Route::delete('/{order}/rooms/{room}/windows/{window}/destroy', 'RoomWindowController@destroy');
            });
        });

    });

    Route::group(['namespace' => 'Api\Types'], function () {


        /**
         * Room Types
        */
        Route::get('/room_types', 'RoomTypeController@index');

        /**
         * Managers
        */
        Route::get('/managers', 'ManagerController@index');

        /**
         * Services Units
        */
        Route::get('/units', 'UnitController@index');

        /**
         * Services Units
        */
        Route::get('/service_types', 'ServiceTypeController@index');

        /**
         * Material Units
        */
        Route::get('/material_units', 'MaterialUnitController@index');
    });



/**
 * Services
*/
Route::group(['prefix' => 'services', 'namespace' => 'Api\Services'], function () {
       Route::get('/', 'ServiceController@index');
       Route::post('/store', 'ServiceController@store');
       Route::get('/{service}', 'ServiceController@show');
       Route::patch('/{service}/update', 'ServiceController@update');
       Route::delete('/{service}/destroy', 'ServiceController@destroy');
});

/**
 * Materials
*/
Route::group(['namespace' => 'Api\Materials', 'middleware' => 'cacheResponse:30'], function () {
    Route::get('/materials/search', 'MaterialController@search');
    Route::post('/materials/store', 'MaterialController@store');
    Route::delete('/materials/{material}/delete', 'MaterialController@destroy');


    /**
     * Services - Materials
    */
    Route::group(['namespace' => 'Services'], function () {
        Route::get('/services/{service}/materials', 'ServiceMaterialController@index');
        Route::post('/services/{service}/materials/store', 'ServiceMaterialController@store');
    });
});
