<?php

use Pk\Core\Controllers\AppointmentController;
use Pk\Core\Controllers\AuthController;
use Pk\Core\Controllers\PageController;
use Pk\Core\Controllers\UserController;
use Pk\Core\Controllers\VaccinationCenterController;
use Pk\Core\Helpers\Auth;
use Pk\Core\Helpers\Route;
use Pk\Core\Middleware\Guest;
use Pk\Core\Middleware\HasRoleCitizen;
use Pk\Core\Middleware\HasRoleDoctor;
use Pk\Core\Middleware\RequiresLogin;
use Pk\Core\Middleware\SanitizeInput;
use Pk\Core\Middleware\UserCanCreateAppointment;
use Pk\Core\Middleware\UserHasAppointment;
use Pk\Core\Middleware\UserHasNoAppointment;
use Pk\Core\Middleware\UserHasVaccinationCenter;

/**
 * Δήλωση των uri της εφαρμογής.
 * 
 * Τα uri δηλώνονται με την εξής μορφή:
 * Route::<όνομα_μεθόδου_http>(
 *  '<το_uri_του_route>', 
 *  [<διαδρομή_και_όνομα_controller>, <όνομα_μεθόδου>],
 *  [διαδρομή_και_όνομα_middleware]
 * ) 
 */
return [

    Route::get('/', [PageController::class, 'index']),

    Route::get('/login', [PageController::class, 'login'], [Guest::class]),
    Route::post('/login', [AuthController::class, 'login'], [SanitizeInput::class]),
    Route::get('/me', [PageController::class, 'me'], [RequiresLogin::class]),
    Route::get('/vac_centers', [PageController::class, 'vacCenters']),
    Route::get('/vac_guide', [PageController::class, 'vacGuide']),
    Route::get('/signin', [PageController::class, 'signin']),
    Route::get('/anakoinoseis', [PageController::class, 'anakoinoseis']),
    Route::get('/anakoinoseis/{id}', [PageController::class, 'viewAnakoinosi']),

    Route::get('/logout', [AuthController::class, 'logout']),

    Route::get('/register', [PageController::class, 'register'], [Guest::class]),

    Route::get('/me/appointments/report', [PageController::class, 'report'], [RequiresLogin::class, HasRoleDoctor::class]),

    Route::get(
        '/vaccination_centers/{id}/appointments',
        [VaccinationCenterController::class, 'getAppointments'],
        [RequiresLogin::class]
    ),

    Route::post(
        '/vaccination_centers/{id}/appointments',
        [VaccinationCenterController::class, 'storeAppointment'],
        [
            RequiresLogin::class,
            HasRoleCitizen::class,
            SanitizeInput::class,
            UserHasNoAppointment::class,
        ]
    ),

    Route::get('/me/canScheduleAppointment', [UserController::class, 'canScheduleAppointment'], [
        RequiresLogin::class,
        HasRoleCitizen::class,
    ]),

    Route::get('/me/canSelectVaccinationCenter', [UserController::class, 'canSelectVaccinationCenter'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
    ]),

    Route::get('/me/vaccination_centers', [PageController::class, 'selectVaccinationCenter'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
    ]),

    Route::post('/me/vaccination_centers', [UserController::class, 'assignUserToVaccinationCenter'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
        SanitizeInput::class,
    ]),

    Route::post('/users', [UserController::class, 'store'], [
        Guest::class,
        SanitizeInput::class,
    ]),

    Route::get('/appointments', [AppointmentController::class, 'view'], [
        RequiresLogin::class,
        UserCanCreateAppointment::class,
    ]),
    Route::get('/appointments/{id}/complete', [AppointmentController::class, 'complete'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
    ]),
    Route::get('/me/appointments', [AppointmentController::class, 'showUserAppointments'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
        UserHasVaccinationCenter::class,
    ]),
    Route::get('/me/appointments/report/download', [AppointmentController::class, 'downloadReport'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
        UserHasVaccinationCenter::class,
    ]),
    Route::get('/me/appointments/report/view', [AppointmentController::class, 'viewReport'], [
        RequiresLogin::class,
        HasRoleDoctor::class,
        UserHasVaccinationCenter::class,
    ]),
    Route::delete('/me/appointment', [AppointmentController::class, 'deleteUserAppointment'], [
        RequiresLogin::class,
        HasRoleCitizen::class,
        UserHasAppointment::class,
    ]),

];
