<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', ['uses' => 'AuthController@authFail']);
    Route::post('/login', 'AuthController@authenticate');
});

Route::group(['middleware' => 'auth:api'], function () {


    Route::group(['namespace' => 'Support'], function () {
        Route::post('/check/patient-phone', ['uses' => 'SupportController@checkPatientPhone']);
        Route::post('/check/patient-id-number', ['uses' => 'SupportController@checkPatientIdNumber']);
        Route::post('/check/patient-id-card', ['uses' => 'SupportController@checkPatientIdCard']);
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('/me', ['uses' => 'AuthController@me']);
    });

    Route::group(['namespace' => 'Profile'], function () {
        Route::post('/profile/change-password', ['uses' => 'ProfileController@changePassword']);
    });

    Route::group(['namespace' => 'Management'], function () {
        Route::get('/roles', 'RolesController@index');
        Route::get('/permissions', 'PermissionsController@getAllPermissions');
    });


    Route::group(['middleware' => 'subscriptionCheck'], function () {

        Route::group(['namespace' => 'CashFlow'], function () {
            Route::post('/get-cash-boxes', 'CashBoxController@index');
            Route::post(
                '/get-organization-cash-boxes',
                'CashBoxController@getOrganizationCashBoxes'
            );
            Route::apiResource('cash-boxes', 'CashBoxController');
            Route::get('cash-boxes/{id}', 'CashBoxController@show');
            Route::get('check-cash-box/{id}', 'CashBoxController@check');

            Route::get('cash-boxes-array', 'CashBoxController@getArray');
            Route::get('cash-flow-operation-types', 'CashFlowOperationTypesController@index');
            Route::get('cash-flow-types', 'CashFlowOperationTypesController@getCashFlowTypes');
            Route::post('cash-flow-operation-types', 'CashFlowOperationTypesController@store');
            Route::get('check-operation-types/{id}', 'CashFlowOperationTypesController@checkOperationType');
            Route::put('cash-flow-operation-types/{id}', 'CashFlowOperationTypesController@update');
            Route::delete('cash-flow-operation-types/{id}', 'CashFlowOperationTypesController@destroy');
//        Route::post('get-cash-flow-operations', 'CashFlowController@index');
            Route::apiResource('cash-flow-operations', 'CashFlowController');
        });

        Route::group(['namespace' => 'Settings'], function () {
            Route::get('/services', 'ServicesController@index');
            Route::get('/get_services_array', 'ServicesController@getServicesArray');
            Route::get('get_services_array_except_appointment/{id}','ServicesController@getServicesArrayExceptAppointments');
//        Route::get('/services_by_category/{id}','ServicesController@getAllServicesByCategory')->where('category_id', '[0-9]+');
            Route::get('/service_categories', 'ServicesController@getServiceCategories');
            Route::get('/search_services', 'ServicesController@searchServices');
            Route::get('/services/{id}', 'ServicesController@getServiceById');

            Route::post('/services', 'ServicesController@store');
            Route::put('/services/{id}', 'ServicesController@update');

            Route::post('/service_categories', 'ServicesController@storeCategory');
            Route::put('/service_categories/{id}', 'ServicesController@updateCategory');
            Route::delete('/service_categories/{id}', 'ServicesController@deleteCategory');

            Route::get('/positions', 'PositionsController@index');
            Route::get('/positions/{id}', 'PositionsController@show');
            Route::post('/positions', 'PositionsController@store');
            Route::put('/positions/{id}', 'PositionsController@update');
            Route::delete('/positions/{id}', 'PositionsController@destroy');

            Route::get('/employees', 'EmployeesController@index');
            Route::get('/employees/{id}', 'EmployeesController@show');
            Route::post('/employees', 'EmployeesController@store');
            Route::put('/employees/{id}', 'EmployeesController@update');
            Route::delete('/employees/{id}', 'EmployeesController@destroy');
        });

        Route::group(['namespace' => 'Patients'], function () {
            Route::get('/patients', 'PatientsController@index');
            Route::get('/patients/{id}', 'PatientsController@show')->where('id', '[0-9]+');;
            Route::post('/patients', 'PatientsController@store');
            Route::put('/patients/{id}', 'PatientsController@update');
            Route::delete('/patients/{id}', 'PatientsController@destroy');
            Route::get('/patients/organization', ['uses' => 'PatientsController@organizationPatients']);
            Route::get('/patients/search', 'PatientsController@searchPatient');
        });

        Route::group(['namespace' => 'Appointments'], function () {
//            Route::post('/get-appointments', 'AppointmentsController@index');
            Route::apiResource('/appointments', 'AppointmentsController');
            Route::put('/update_appointment_time/{id}','AppointmentsController@updateAppointmentTime');
            Route::get('/get_patient_last_appointments/{patient_id}','AppointmentsController@getPatientLastAppointment');


            Route::get('/appointments/{id}/initial-inspections', 'AppointmentsController@getAppointmentInitialInspections');
            Route::get('/initial_inspection_types', 'InitialInspectionsController@getInitialInspectionTypes');
            Route::post('/initial-inspections', 'InitialInspectionsController@store');
            Route::delete('/initial-inspections/{id}', 'InitialInspectionsController@delete');

            Route::get('/appointments/{id}/treatments', 'AppointmentsController@getAppointmentTreatments');
            Route::get('/appointments/{id}/treatments/{treatment_id}/edit', 'AppointmentsController@editTreatments');
            Route::delete('/appointments/treatments/{treatment_id}', 'AppointmentsController@deleteTreatment');


            Route::get('/diagnosis', 'DiagnosisController@index');
            Route::get('/diagnosis-paginate', 'DiagnosisController@indexPaginate');
            Route::post('/diagnosis', 'DiagnosisController@store');
            Route::get('/diagnosis/{id}', 'DiagnosisController@show');
            Route::get('/diagnosis/{id}/edit', 'DiagnosisController@edit');
            Route::delete('/diagnosis/{id}', 'DiagnosisController@delete');

//            Route::get('/appointments/{id}/treatments', 'AppointmentsController@getAppointmentTreatments');

            Route::group(['prefix' => 'treatments'], function (){
                Route::get('/templates', 'TreatmentsController@indexTemplates');
                Route::get('/templates/{id}', 'TreatmentsController@showTemplate');
                Route::get('/templates-paginate', 'TreatmentsController@indexTemplatesPaginate');

                Route::post('/templates', 'TreatmentsController@storeTemplate');
                Route::post('/types', 'TreatmentsController@storeType');
                Route::post('/types/list', 'TreatmentsController@storeTypeList');
                Route::delete('/types/{id}', 'TreatmentsController@deleteType');
                Route::delete('/options/{id}', 'TreatmentsController@deleteOption');
                Route::delete('/templates/{id}', 'TreatmentsController@deleteTemplate');

                Route::post('/store/list', 'TreatmentsController@storeTreatmentDataList');
                Route::post('/update/list', 'TreatmentsController@updateTreatmentDataList');
            });

        });

        Route::group(['namespace' => 'Materials'], function () {
            Route::apiResource('materials', 'MaterialsController');
            Route::apiResource('material-rests', 'MaterialRestsController');

            Route::post('material-deliveries', 'MaterialRestsController@getDeliveries');
            Route::post(
                'material-rests/delivery',
                'MaterialRestsController@storeDelivery'
            );
            Route::get(
                'material-rests/delivery/{id}',
                'MaterialRestsController@getDelivery'
            );
            Route::put(
                'material-rests/delivery/{id}',
                'MaterialRestsController@updateDelivery'
            );
            Route::delete(
                'material-rests/delivery/{id}',
                'MaterialRestsController@deleteDelivery'
            );
            Route::post('material-usages', 'MaterialRestsController@getUsages');
            Route::get(
                'material-rests/usage/{id}',
                'MaterialRestsController@getUsage'
            );
            Route::post(
                'material-rests/usage',
                'MaterialRestsController@storeUsage'
            );
            Route::put(
                'material-rests/usage/{id}',
                'MaterialRestsController@updateUsage'
            );
            Route::delete(
                'material-rests/usage/{id}',
                'MaterialRestsController@deleteUsage'
            );
        });
    });

});
