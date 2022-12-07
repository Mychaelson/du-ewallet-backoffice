<?php

use App\Http\Controllers\Setting\BankInstructionController;
use Illuminate\Support\Facades\Route;

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

// Route::namespace('\App\Http\Controllers\Auth')->group(function () {
//     $limiter = config('fortify.limiters.login');
//     Route::post('login', 'LoginController@store')->middleware(array_filter([
//         'guest:'.config('fortify.guard'),
//         $limiter ? 'throttle:'.$limiter : null,
//     ]));
// });

Route::get('/', 'HomeController@index')->middleware(['auth:sanctum', 'verified']);

Route::namespace('WalletUser')->group(function () {
    Route::get('/user/list', ['as' => 'user-list', 'uses' => 'UserController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/data-table', ['as' => 'user-list.dt', 'uses' => 'UserController@data_table'])->middleware('ajax');
    Route::get('/user/list/{id}', ['as' => 'user.detail', 'uses' => 'UserController@detail_user'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/ban/{id}', ['as' => 'user.banview', 'uses' => 'UserController@banAccountView'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/ban/{id}', ['as' => 'user.banpost', 'uses' => 'UserController@banAccount'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/unban/{id}', ['as' => 'user.unbanview', 'uses' => 'UserController@unbanAccountView'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/unban/{id}', ['as' => 'user.unbanpost', 'uses' => 'UserController@unbanAccount'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/forcenewpin/{id}', ['as' => 'user.forcepinview', 'uses' => 'UserController@forcePinView'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/forcenewpin/{id}', ['as' => 'user.forcepinpost', 'uses' => 'UserController@forcePinAccount'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/forcelogout/{id}', ['as' => 'user.forcelogoutview', 'uses' => 'UserController@forceLogoutView'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/revokemaindevice/{id}', ['as' => 'user.revokedeviceview', 'uses' => 'UserController@revokeMainDeviceView'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/unkyc/{id}', ['as' => 'user.unkycview', 'uses' => 'UserController@unKYCView'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/watchlist/{id}', ['as' => 'user.watchlistview', 'uses' => 'UserController@watchlistView'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/watchlist/{id}', ['as' => 'user.watchlistpost', 'uses' => 'UserController@watchListAccount'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/user/kyc', ['as' => 'user-kyc', 'uses' => 'KYCController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/kyc/data-table', ['as' => 'user-kyc.dt', 'uses' => 'KYCController@data_table'])->middleware('ajax');
    Route::get('/user/kyc/{id}', ['as' => 'user-kyc.detail', 'uses' => 'KYCController@detail_user'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/kycpost/{id}', ['as' => 'user-kyc.update', 'uses' => 'KYCController@update'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/user/closeaccount', ['as' => 'user-close-accounts', 'uses' => 'CloseAccountsController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/kyc/data-table', ['as' => 'user-closeaccount.dt', 'uses' => 'CloseAccountsController@data_table'])->middleware('ajax');
    Route::get('/user/closeaccount/{id}', ['as' => 'user.closeaccount.form', 'uses' => 'CloseAccountsController@form'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/user/closeaccount/store', ['as' => 'user-closeaccount-store', 'uses' => 'CloseAccountsController@store'])->middleware(['auth:sanctum', 'verified']);


    Route::get('/user/groups', ['as' => 'user-groups', 'uses' => 'GroupsController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/groups/data-table', ['as' => 'user-groups.dt', 'uses' => 'GroupsController@data_table'])->middleware('ajax');
    Route::get('/groups/edit/{id}', ['as' => 'user-groups.edit', 'uses' => 'GroupsController@detail_user'])->middleware(['auth:sanctum', 'verified']);


    Route::get('/user/blacklist', ['as' => 'user-blacklist', 'uses' => 'BlacklistController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/blacklist/data-table', ['as' => 'blacklist.dt', 'uses' => 'BlacklistController@data_table'])->middleware('ajax');
    Route::post('/blacklist/delete', ['as' => 'blacklist.delete', 'uses' => 'BlacklistController@delete'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/blacklist/edit/{id}', ['as' => 'blacklist.edit', 'uses' => 'BlacklistController@edit'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/blacklist/update', ['as' => 'blacklist.update', 'uses' => 'BlacklistController@update'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/blacklist/add', ['as' => 'blacklist.add', 'uses' => 'BlacklistController@add'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/blacklist/save', ['as' => 'blacklist.save', 'uses' => 'BlacklistController@save'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/user/watchlist', ['as' => 'user-watchlist', 'uses' => 'WatchlistController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/watchlist/data-table', ['as' => 'watchlist.dt', 'uses' => 'WatchlistController@data_table'])->middleware('ajax');

    Route::get('/user/statistic', ['as' => 'user-statistic', 'uses' => 'StatisticController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/statistic/trans-chart', ['as' => 'statistic.trans-chart', 'uses' => 'StatisticController@trans_chart'])->middleware('ajax');


});

Route::namespace('\App\Http\Controllers\Wallet')->group(function () {
    Route::get('/wallet/emoney', ['as' => 'wallet-emoney', 'uses' => 'WalletController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/data-table', ['as' => 'wallet-emoney.dt', 'uses' => 'WalletController@dataTable'])->middleware('ajax');
    Route::get('/wallet/emoney/{id}', ['as' => 'wallet.emoney.detail', 'uses' => 'WalletController@update'])->middleware(['auth:sanctum', 'verified']);

    Route::post('/wallet/wallet-setting', ['as' => 'wallet.setting.get', 'uses' => 'WalletController@walletSetting'])->middleware('ajax');

    Route::get('/wallet/emoney/reversal/{id}', ['as' => 'wallet.emoney.reversal', 'uses' => 'WalletController@reversal'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/wallet/emoney/limit/{id}', ['as' => 'wallet.emoney.limit', 'uses' => 'WalletController@limit'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/update-limit', ['as' => 'wallet.emoney.update.limit', 'uses' => 'WalletController@updateLimit'])->middleware(['auth:sanctum', 'verified', 'ajax']);
    Route::post('/wallet/emoney/wallet-limit-req-table', ['as' => 'wallet.emoney.limit.req.table', 'uses' => 'WalletController@walletLimitReqTable'])->middleware('ajax');
    Route::post('/wallet/emoney/wallet-limit-req-history-table', ['as' => 'wallet.emoney.limit.req.history.table', 'uses' => 'WalletController@walletLimitReqHistoryTable'])->middleware('ajax');
    Route::post('/wallet/emoney/wallet-limit-req', ['as' => 'wallet.emoney.limit.req.action', 'uses' => 'WalletController@walletLimitReqAction'])->middleware('ajax');
    Route::post('/wallet/emoney/wallet-limit-req-approval', ['as' => 'wallet.emoney.limit.req.approval', 'uses' => 'WalletController@walletLimitApproval'])->middleware('ajax');


    Route::get('/wallet/emoney/switch/{id}', ['as' => 'wallet.emoney.switch', 'uses' => 'WalletController@switch'])->middleware(['auth:sanctum', 'verified']);

    Route::post('/wallet/emoney/update-lock', ['as' => 'wallet.emoney.update.lock', 'uses' => 'WalletController@updateLock'])->middleware('ajax');

    Route::get('/wallet/emoney/return-adjustment/{id}', ['as' => 'wallet.emoney.return.adjustment', 'uses' => 'WalletController@returnAdjustment'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/return-adjustment', ['as' => 'wallet.emoney.return.adjustment.action', 'uses' => 'WalletController@returnAdjustmentAction'])->middleware('ajax');

    Route::get('/wallet/emoney/withdraw-fee/{id}', ['as' => 'wallet.emoney.withdraw.fee', 'uses' => 'WalletController@withdrawFee'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/withdraw-fee', ['as' => 'wallet.emoney.withdraw.fee.action', 'uses' => 'WalletController@withdrawFeeAction'])->middleware('ajax');
    Route::post('/wallet/emoney/withdraw-fee-req-table', ['as' => 'wallet.emoney.withdraw.req.table', 'uses' => 'WalletController@withdrawFeeTable'])->middleware('ajax');
    Route::post('/wallet/emoney/withdraw-fee-req-approval', ['as' => 'wallet.emoney.withdraw.req.approval', 'uses' => 'WalletController@withdrawFeeReqApproval'])->middleware('ajax');

    Route::get('/wallet/emoney/adjustment/{id}', ['as' => 'wallet.emoney.adjustment', 'uses' => 'WalletController@adjustment'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/adjustment', ['as' => 'wallet.emoney.adjustment.action', 'uses' => 'WalletController@adjustmentAction'])->middleware('ajax');

    Route::get('/wallet/emoney/tf-blacklist/{id}', ['as' => 'wallet.emoney.tf.blacklist', 'uses' => 'WalletController@transferBlacklist'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/tf-blacklist', ['as' => 'wallet.emoney.tf.blacklist.action', 'uses' => 'WalletController@transferBlacklistAction'])->middleware('ajax');
    Route::post('/wallet/emoney/tf-blacklist/list-user', ['as' => 'wallet.emoney.tf.blacklist.list.user', 'uses' => 'WalletController@getUserList'])->middleware('ajax');
    Route::post('/wallet/emoney/tf-blacklist/add', ['as' => 'wallet.emoney.tf.blacklist.add', 'uses' => 'WalletController@reqTfBlacklist'])->middleware(['auth:sanctum', 'verified', 'ajax']);
    Route::post('/wallet/emoney/tf-blacklist-req-table', ['as' => 'wallet.emoney.tf.blacklist.req.table', 'uses' => 'WalletController@TfBlacklistReqTable'])->middleware('ajax');
    Route::post('/wallet/emoney/tf-blacklist-req-approval', ['as' => 'wallet.emoney.tf.blacklist.req.approval', 'uses' => 'WalletController@tfBlacklistReqApproval'])->middleware('ajax');

    Route::get('/wallet/emoney/wd-blacklist/{id}', ['as' => 'wallet.emoney.wd.blacklist', 'uses' => 'WalletController@withdrawBlacklist'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/emoney/wd-blacklist', ['as' => 'wallet.emoney.wd.blacklist.action', 'uses' => 'WalletController@withdrawBlacklistAction'])->middleware('ajax');
    Route::post('/wallet/emoney/wd-blacklist/list-user-accounts', ['as' => 'wallet.emoney.wd.blacklist.list.accounts', 'uses' => 'WalletController@getUserAcc'])->middleware('ajax');
    Route::post('/wallet/emoney/wd-blacklist/add', ['as' => 'wallet.emoney.wd.blacklist.add', 'uses' => 'WalletController@reqWdBlacklist'])->middleware(['auth:sanctum', 'verified', 'ajax']);
    Route::post('/wallet/emoney/wd-blacklist-req-table', ['as' => 'wallet.emoney.wd.blacklist.req.table', 'uses' => 'WalletController@WdBlacklistReqTable'])->middleware('ajax');
    Route::post('/wallet/emoney/wd-blacklist-req', ['as' => 'wallet.emoney.wd.blacklist.req.action', 'uses' => 'WalletController@WdBlacklistReqAction'])->middleware('ajax');
    Route::post('/wallet/emoney/wd-blacklist-req-approval', ['as' => 'wallet.emoney.wd.blacklist.req.approval', 'uses' => 'WalletController@wdBlacklistReqApproval'])->middleware('ajax');

    Route::get('/wallet/setting', ['as' => 'wallet-setting', 'uses' => 'SettingController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/setting/data-table', ['as' => 'wallet-setting.dt', 'uses' => 'SettingController@dataTable'])->middleware('ajax');
    Route::get('/wallet/setting/{id}', ['as' => 'wallet.setting.edit', 'uses' => 'SettingController@update'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/setting/save', ['as' => 'wallet-setting-store', 'uses' => 'SettingController@store']);

    Route::get('/wallet/label', ['as' => 'wallet-label', 'uses' => 'LabelController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/label/data-table', ['as' => 'wallet-label.dt', 'uses' => 'LabelController@dataTable'])->middleware('ajax');
    Route::get('/wallet/label/add', ['as' => 'wallet.label.add', 'uses' => 'LabelController@add'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/wallet/label/{id}', ['as' => 'wallet.label.edit', 'uses' => 'LabelController@update'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/label/save', ['as' => 'wallet-label-store', 'uses' => 'LabelController@store']);

    Route::get('/wallet/history', ['as' => 'wallet-history', 'uses' => 'HistoryController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/history/data-table', ['as' => 'wallet-history.dt', 'uses' => 'HistoryController@dataTable'])->middleware('ajax');
    Route::get('/wallet/history/{id}', ['as' => 'wallet.history.edit', 'uses' => 'HistoryController@index'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/wallet/statistics', ['as' => 'wallet-statistic', 'uses' => 'StatisticController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/statistics/data-table', ['as' => 'wallet-statistics.dt', 'uses' => 'StatisticController@dataTable'])->middleware('ajax');
    Route::get('/wallet/statistics/{id}', ['as' => 'wallet.statistics.edit', 'uses' => 'StatisticController@index'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/wallet/switch', ['as' => 'wallet-switch', 'uses' => 'SwitchController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/switch/data-table', ['as' => 'wallet-switch.dt', 'uses' => 'SwitchController@dataTable'])->middleware('ajax');
    Route::get('/wallet/switch/add', ['as' => 'wallet.switch.add', 'uses' => 'SwitchController@add'])->middleware(['auth:sanctum', 'verified']);
    Route::get('/wallet/switch/{id}', ['as' => 'wallet.switch.edit', 'uses' => 'SwitchController@update'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/switch/save', ['as' => 'wallet-switching-store', 'uses' => 'SwitchController@store']);

    Route::get('/wallet/unique', ['as' => 'wallet-unique', 'uses' => 'UniqueCodeController@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/unique/data-table', ['as' => 'wallet-unique.dt', 'uses' => 'UniqueCodeController@dataTable'])->middleware('ajax');
    Route::get('/wallet/unique/{id}', ['as' => 'wallet.unique.edit', 'uses' => 'UniqueCodeController@update'])->middleware(['auth:sanctum', 'verified']);

    Route::get('/wallet/inout', ['as' => 'wallet-inout', 'uses' => 'InOutContoller@index'])->middleware(['auth:sanctum', 'verified']);
    Route::post('/wallet/inout/data-table', ['as' => 'wallet-inout.dt', 'uses' => 'InOutContoller@dataTable'])->middleware('ajax');
});

Route::namespace('Ticket')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/ticket/list', ['as' => 'ticket-list', 'uses' => 'TicketController@index']);
    Route::post('/ticket/data-table', ['as' => 'ticket-list.dt', 'uses' => 'TicketController@data_table'])->middleware('ajax');
    Route::get('/ticket/list/{id}', ['as' => 'ticket.detail', 'uses' => 'TicketController@show']);
    Route::post('/ticket/comment', ['as' => 'ticket-add-comment', 'uses' => 'TicketController@comment']);

    Route::get('/ticket/category', ['as' => 'ticket-category-list', 'uses' => 'TicketCategoryController@index']);
    Route::get('/ticket/category/add', ['as' => 'ticket-category-add', 'uses' => 'TicketCategoryController@add']);
    Route::get('/ticket/category/{id}', ['as' => 'ticket-category-detail', 'uses' => 'TicketCategoryController@detail']);
    Route::post('/ticket/category/save', ['as' => 'ticket-category-store', 'uses' => 'TicketCategoryController@store']);
    Route::post('/ticket/category/{id}/update', ['as' => 'ticket-category-update', 'uses' => 'TicketCategoryController@update']);
    Route::get('/ticket/category/{id}/delete', ['as' => 'ticket-category-delete', 'uses' => 'TicketCategoryController@delete']);
});

Route::prefix('auth_user')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('', 'UserController@index')->name('users');
    Route::post('dt', 'UserController@usersDT')->name('users.dt');
    Route::get('add_user', 'UserController@addUser')->name('users.add');
    Route::post('save_user', 'UserController@saveUser')->name('users.save');
    Route::get('profile/{id}', 'UserController@profile')->name('users.profile');
    Route::post('update/{id}', 'UserController@updateUser')->name('users.update');
    Route::get('password/{id}', 'UserController@password')->name('users.password');
    Route::post('password/{id}', 'UserController@updateUserPassword')->name('users.updatePassword');
    Route::post('delete', 'UserController@deleteUser')->name('users.delete');
    Route::get('permission/{id}', 'UserController@permission')->name('users.permission');
    Route::post('updatePermission/{id}', 'UserController@updatePermission')->name('users.updatePermission');

    Route::get('log', 'UserController@log')->name('users.log');
    Route::post('logdt', 'UserController@usersLogDT')->name('users.logdt');
});

Route::namespace('\App\Http\Controllers\Banner')->group(function () {
    Route::prefix('banner')->group(function () {
        Route::get('list', ['as' => 'banner', 'uses' => 'BannerController@index'])->middleware(['auth:sanctum', 'verified']);
        Route::get('create', ['as' => 'banner.create', 'uses' => 'BannerController@create'])->middleware(['auth:sanctum', 'verified']);
        Route::post('save', ['as' => 'banner.save', 'uses' => 'BannerController@save'])->middleware(['auth:sanctum', 'verified']);
        Route::post('data-table', ['as' => 'banner.dt', 'uses' => 'BannerController@data_table'])->middleware('ajax');
        Route::post('update', ['as' => 'banner.update', 'uses' => 'BannerController@update'])->middleware(['auth:sanctum', 'verified']);
        Route::post('delete', ['as' => 'banner.delete', 'uses' => 'BannerController@delete'])->middleware(['auth:sanctum', 'verified']);
        Route::get('edit/{id}', ['as' => 'banner.edit', 'uses' => 'BannerController@edit'])->middleware(['auth:sanctum', 'verified']);

    });
});

Route::namespace('\App\Http\Controllers\Documents\YamisokPayDocument')->group(function () {
    Route::resource('docs', 'DocumentController')->middleware(['auth:sanctum', 'verified']);
    Route::post('/doc/data-table', ['as' => 'doc.dt', 'uses' => 'DocumentController@data_table'])->middleware('ajax');
});

Route::namespace('\App\Http\Controllers\Documents\Report')->group(function () {
    Route::resource('report', 'ReportController')->middleware(['auth:sanctum', 'verified']);
    Route::post('/report/data-table', ['as' => 'report.dt', 'uses' => 'ReportController@data_tables'])->middleware('ajax');
    Route::post('/report/req-data-table', ['as' => 'report.req.dt', 'uses' => 'ReportController@reqDocTable'])->middleware('ajax');

});

Route::namespace('\App\Http\Controllers\OTP')->group(function () {
    Route::prefix('/otp')->group(function () {
        Route::get('active', 'OTPController@active')->middleware(['auth:sanctum', 'verified']);
        Route::post('/active/data-table', ['as' => 'otp-active.dt', 'uses' => 'OTPController@data_tables_otp_active'])->middleware('ajax');

        Route::get('blocked', 'OTPController@blocked')->middleware(['auth:sanctum', 'verified']);
        Route::post('/blocked/data-table', ['as' => 'otp-blocked.dt', 'uses' => 'OTPController@data_tables_otp_blocked'])->middleware('ajax');

        Route::get('email', 'OTPController@email')->middleware(['auth:sanctum', 'verified']);
        Route::post('/email/data-table', ['as' => 'otp-email.dt', 'uses' => 'OTPController@data_tables_otp_email'])->middleware('ajax');

    });
});

Route::namespace('\App\Http\Controllers\Documents\Help')->group(function () {
    Route::prefix('/help')->group(function () {
        Route::get('category', 'HelpCategoryController@index_category')->name('index-category')->middleware(['auth:sanctum', 'verified']);
        Route::post('/category/data-table', ['as' => 'category.dt', 'uses' => 'HelpCategoryController@data_tables_category'])->middleware('ajax');

        Route::get('index-by-category/{id}', 'HelpCategoryController@index')->name('index-by-category')->middleware(['auth:sanctum', 'verified']);
        Route::get('create-by-category/{id}', 'HelpCategoryController@create')->name('create-by-category')->middleware(['auth:sanctum', 'verified']);
        Route::resource('resource-help', 'HelpCategoryController')->middleware(['auth:sanctum', 'verified']);
    });
});
Route::namespace('\App\Http\Controllers\UploadImage')->group(function () {
    Route::prefix('upload')->group(function () {
        Route::post('imageS3', ['as' => 'image.uploads3', 'uses' => 'UploadImageController@uploadImageS3'])->middleware('ajax');
    });
});

Route::namespace('\App\Http\Controllers\Promotion')->group(function () {
    Route::prefix('promotion/cashback')->group(function () {
        Route::get('', ['as' => 'cashback', 'uses' => 'CashbackController@index'])->middleware(['auth:sanctum', 'verified']);
        Route::post('data-table', ['as' => 'cashback.dt', 'uses' => 'CashbackController@data_table'])->middleware('ajax');
        Route::get('create', ['as' => 'cashback.create', 'uses' => 'CashbackController@create'])->middleware(['auth:sanctum', 'verified']);
        Route::post('save', ['as' => 'cashback.save', 'uses' => 'CashbackController@save'])->middleware(['auth:sanctum', 'verified']);
        Route::post('update', ['as' => 'cashback.update', 'uses' => 'CashbackController@update'])->middleware(['auth:sanctum', 'verified']);
        Route::post('aprove', ['as' => 'cashback.aprove', 'uses' => 'CashbackController@aprove'])->middleware(['auth:sanctum', 'verified']);
        Route::post('delete', ['as' => 'cashback.delete', 'uses' => 'CashbackController@delete'])->middleware(['auth:sanctum', 'verified']);
        Route::get('edit/{id}', ['as' => 'cashback.edit', 'uses' => 'CashbackController@edit'])->middleware(['auth:sanctum', 'verified']);
        Route::get('detail/{id}', ['as' => 'cashback.detail', 'uses' => 'CashbackController@detail'])->middleware(['auth:sanctum', 'verified']);
        Route::post('approve', ['as' => 'cashback.approve', 'uses' => 'CashbackController@aprroveDetail'])->middleware('ajax');

    });

    Route::prefix('promotion/mission')->group(function () {
        Route::get('', ['as' => 'mission', 'uses' => 'MissionController@index'])->middleware(['auth:sanctum', 'verified']);
        Route::post('data-table', ['as' => 'mission.dt', 'uses' => 'MissionController@data_table'])->middleware('ajax');
        Route::get('create', ['as' => 'mission.create', 'uses' => 'MissionController@create'])->middleware(['auth:sanctum', 'verified']);
        Route::post('save', ['as' => 'mission.save', 'uses' => 'MissionController@save'])->middleware(['auth:sanctum', 'verified']);
        Route::post('update', ['as' => 'mission.update', 'uses' => 'MissionController@update'])->middleware(['auth:sanctum', 'verified']);
        Route::post('delete', ['as' => 'mission.delete', 'uses' => 'MissionController@delete'])->middleware(['auth:sanctum', 'verified']);
        Route::get('edit/{id}', ['as' => 'mission.edit', 'uses' => 'MissionController@edit'])->middleware(['auth:sanctum', 'verified']);
        Route::get('detail/{id}', ['as' => 'mission.detail', 'uses' => 'MissionController@detail'])->middleware(['auth:sanctum', 'verified']);
        Route::post('aprrove', ['as' => 'mission.approve', 'uses' => 'MissionController@aprroveDetail'])->middleware('ajax');
        Route::post('add-mission', ['as' => 'mission.addlistmission', 'uses' => 'MissionController@addlistmission'])->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-mission/{id}', ['as' => 'mission.editmission', 'uses' => 'MissionController@editmission'])->middleware('ajax');
        Route::post('update-mission', ['as' => 'mission.updatemission', 'uses' => 'MissionController@updatemission'])->middleware(['auth:sanctum', 'verified']);
        Route::post('delete-mission', ['as' => 'mission.deletemission', 'uses' => 'MissionController@deletemission'])->middleware(['auth:sanctum', 'verified']);


    });

    Route::prefix('promotion/catalogue')->group(function () {
        Route::get('', ['as' => 'catalogue', 'uses' => 'CatalogueController@index'])->middleware(['auth:sanctum', 'verified']);
        Route::post('data-table', ['as' => 'catalogue.dt', 'uses' => 'CatalogueController@data_table'])->middleware('ajax');
        Route::get('create', ['as' => 'catalogue.create', 'uses' => 'CatalogueController@create'])->middleware(['auth:sanctum', 'verified']);
        Route::post('save', ['as' => 'catalogue.save', 'uses' => 'CatalogueController@save'])->middleware(['auth:sanctum', 'verified']);
        Route::post('update', ['as' => 'catalogue.update', 'uses' => 'CatalogueController@update'])->middleware(['auth:sanctum', 'verified']);
        Route::post('delete', ['as' => 'catalogue.delete', 'uses' => 'CatalogueController@delete'])->middleware(['auth:sanctum', 'verified']);
        Route::get('edit/{id}', ['as' => 'catalogue.edit', 'uses' => 'CatalogueController@edit'])->middleware(['auth:sanctum', 'verified']);
        Route::get('detail/{id}', ['as' => 'catalogue.detail', 'uses' => 'CatalogueController@detail'])->middleware(['auth:sanctum', 'verified']);
        Route::post('aprrove', ['as' => 'catalogue.approve', 'uses' => 'CatalogueController@aprroveDetail'])->middleware('ajax');
    });

});

Route::namespace('\App\Http\Controllers\WalletUser')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/kyclog', 'KycLogController@index')->middleware(['auth:sanctum', 'verified']);
        Route::post('/kyclog/data-table', ['as' => 'kyclog.dt', 'uses' => 'KycLogController@data_tables'])->middleware('ajax');
    });
});

Route::namespace('\App\Http\Controllers\user')->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('closelog', 'CloseAccountsLogController@index')->middleware(['auth:sanctum', 'verified']);
        Route::post('/closelog/data-table', ['as' => 'closelog.dt', 'uses' => 'CloseAccountsLogController@data_tables'])->middleware('ajax');
    });
});

Route::namespace('\App\Http\Controllers\Media')->group(function () {
        Route::get('file/list', 'MediaController@index')->middleware(['auth:sanctum', 'verified']);
        Route::post('/media', ['as' => 'media.dt', 'uses' => 'MediaController@data_tables'])->middleware('ajax');
        Route::post('media-upload', 'MediaController@upload')->name('media-upload');
    });

Route::namespace('\App\Http\Controllers\Documents\Help')->group(function () {
    Route::prefix('/help')->group(function () {
        Route::get('category', 'HelpCategoryController@index_category')->name('index-category')->middleware(['auth:sanctum', 'verified']);
        Route::post('/category/data-table', ['as' => 'category.dt', 'uses' => 'HelpCategoryController@data_tables_category'])->middleware('ajax');

        Route::get('index-by-category/{id}', 'HelpCategoryController@index')->name('index-by-category')->middleware(['auth:sanctum', 'verified']);
        Route::get('create-by-category/{id}', 'HelpCategoryController@create')->name('create-by-category')->middleware(['auth:sanctum', 'verified']);
        Route::resource('resource-help', 'HelpCategoryController')->middleware(['auth:sanctum', 'verified']);
    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('master-activity', 'MasterActivityController@index')->name('master-activity')->middleware(['auth:sanctum', 'verified']);
        Route::post('/master-activity/data-table', ['as' => 'master-activity.dt', 'uses' => 'MasterActivityController@data_tables'])->middleware('ajax');
        Route::post('create-master-activity', 'MasterActivityController@create')->name('create-master-activity')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-master-activity/{id}', 'MasterActivityController@edit')->name('edit-master-activity')->middleware(['auth:sanctum', 'verified']);
        Route::put('edit-process-master-activity', 'MasterActivityController@edit_process')->name('edit-process-master-activity')->middleware(['auth:sanctum', 'verified']);
        Route::delete('delete-master-activity{id}', 'MasterActivityController@delete')->name('delete-master-activity')->middleware(['auth:sanctum', 'verified']);

        Route::get('/bank-instruction', ['as' => 'setting-bank-instruction', 'uses' => 'BankInstructionController@index'])->middleware(['auth:sanctum', 'verified']);
        Route::post('/bank-instruction/data-table', ['as' => 'bank-instruction.dt', 'uses' => 'BankInstructionController@data_tables'])->middleware('ajax');
        Route::get('/bank-instruction/detail/{id}', ['as' => 'setting-bank-instruction-detail', 'uses' => 'BankInstructionController@bankInstructionDetail'])->middleware(['auth:sanctum', 'verified']);
        Route::post('/bank-instruction/detail/data-table', ['as' => 'bank-instruction-detail.dt', 'uses' => 'BankInstructionController@data_tables_detail'])->middleware('ajax');
        // Route::get('/bank-instruction/method-detail/{method}', ['as' => 'setting-bank-instruction-detail', 'uses' => 'BankInstructionController@bankInstructionMethodDetail'])->middleware(['auth:sanctum', 'verified']);
        Route::post('/bank-instruction/method-detail/data-table', ['as' => 'bank-instruction-method-detail.dt', 'uses' => 'BankInstructionController@data_tables_method_detail'])->middleware('ajax');

        Route::post('/bank-instruction/create', ['as' => 'create-bank-instruction', 'uses' => 'BankInstructionController@create'])->middleware(['auth:sanctum', 'verified']);
        Route::post('/bank-instruction-detail/create', ['as' => 'create-bank-instruction-detail', 'uses' => 'BankInstructionController@createDetail'])->middleware(['auth:sanctum', 'verified']);
    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('master-jobs', 'MasterJobsController@index')->name('master-jobs')->middleware(['auth:sanctum', 'verified']);
        Route::post('/master-jobs/data-table', ['as' => 'master-jobs.dt', 'uses' => 'MasterJobsController@data_tables'])->middleware('ajax');
        Route::post('create-master-jobs', 'MasterJobsController@create')->name('create-master-jobs')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-master-jobs/{id}', 'MasterJobsController@edit')->name('edit-master-jobs')->middleware(['auth:sanctum', 'verified']);
        Route::put('edit-process-master-jobs', 'MasterJobsController@edit_process')->name('edit-process-master-jobs')->middleware(['auth:sanctum', 'verified']);
        Route::delete('delete-master-jobs{id}', 'MasterJobsController@delete')->name('delete-master-jobs')->middleware(['auth:sanctum', 'verified']);
    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('params', 'ParamsController@index')->name('params')->middleware(['auth:sanctum', 'verified']);
        Route::post('/params/data-table', ['as' => 'params.dt', 'uses' => 'ParamsController@data_tables'])->middleware('ajax');
        Route::post('create-params', 'ParamsController@create')->name('create-params')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-params/{id}', 'ParamsController@edit')->name('edit-params')->middleware(['auth:sanctum', 'verified']);
        Route::put('edit-process-params/{id}', 'ParamsController@edit_process')->name('edit-process-params')->middleware(['auth:sanctum', 'verified']);
        Route::delete('delete-params{id}', 'ParamsController@delete')->name('delete-params')->middleware(['auth:sanctum', 'verified']);
    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('debt_collection', 'DebtCollectionController@index')->name('debt-collection')->middleware(['auth:sanctum', 'verified']);
        Route::post('/debt_collection/data-table', ['as' => 'debt_collection.dt', 'uses' => 'DebtCollectionController@data_tables'])->middleware('ajax');
    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('master_role', 'MasterRoleController@index')->name('master-role')->middleware(['auth:sanctum', 'verified']);
        Route::post('/master_role/data-table', ['as' => 'master-role.dt', 'uses' => 'MasterRoleController@data_tables'])->middleware('ajax');

        Route::get('create-master-role', 'MasterRoleController@create')->name('create-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::post('store-master-role', 'MasterRoleController@store')->name('store-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-master-role-{id}', 'MasterRoleController@edit')->name('edit-master-role')->middleware(['auth:sanctum', 'verified']);

    });
});

Route::namespace('\App\Http\Controllers\Setting')->group(function () {
    Route::prefix('/setting')->group(function () {
        Route::get('master_role', 'MasterRoleController@index')->name('master-role')->middleware(['auth:sanctum', 'verified']);
        Route::post('/master_role/data-table', ['as' => 'master-role.dt', 'uses' => 'MasterRoleController@data_tables'])->middleware('ajax');

        Route::get('create-master-role', 'MasterRoleController@create')->name('create-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::post('store-master-role', 'MasterRoleController@store')->name('store-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-master-role-{id}', 'MasterRoleController@edit')->name('edit-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::put('update-master-role-{id}', 'MasterRoleController@update')->name('update-master-role')->middleware(['auth:sanctum', 'verified']);
        Route::delete('delete-master-role-{id}', 'MasterRoleController@delete')->name('delete-master-role')->middleware(['auth:sanctum', 'verified']);

    });
});


Route::namespace('\App\Http\Controllers\PPOB')->group(function () {
    Route::prefix('/ppob')->group(function () {
        Route::get('product', 'ProductV2Controller@index')->name('product')->middleware(['auth:sanctum', 'verified']);
        Route::post('/product/data-table', ['as' => 'product-v2.dt', 'uses' => 'ProductV2Controller@data_tables'])->middleware('ajax');
        Route::get('/get_product_service/{code}', 'ProductV2Controller@product_service')->name('get_product_service')->middleware(['auth:sanctum', 'verified']);
        Route::get('detail-product/{code}', 'ProductV2Controller@detail')->name('detail-product')->middleware(['auth:sanctum', 'verified']);
        Route::get('edit-product/{code}', 'ProductV2Controller@edit')->name('edit-product')->middleware(['auth:sanctum', 'verified']);
        Route::put('edit-process-product/{code}', 'ProductV2Controller@update')->name('edit-process-product')->middleware(['auth:sanctum', 'verified']);
        });
});

Route::namespace('\App\Http\Controllers\PPOB')->group(function () {
    Route::prefix('/ppob')->group(function () {
        Route::get('product_category', 'ProductCategoryController@index')->name('product_category')->middleware(['auth:sanctum', 'verified']);
        Route::post('/product_category/data-table', ['as' => 'product-category.dt', 'uses' => 'ProductCategoryController@data_tables'])->middleware('ajax');

        Route::get('/create-product-category', 'ProductCategoryController@create')->name('create-product-category')->middleware(['auth:sanctum', 'verified']);
        Route::post('/store-product-category', 'ProductCategoryController@store')->name('store-product-category')->middleware(['auth:sanctum', 'verified']);

        Route::get('/edit-product-category/{id}', 'ProductCategoryController@edit')->name('edit-product-category')->middleware(['auth:sanctum', 'verified']);
        Route::put('/update-product-category/{id}', 'ProductCategoryController@update')->name('update-product-category')->middleware(['auth:sanctum', 'verified']);
        Route::delete('/delete-product-category/{id}', 'ProductCategoryController@delete')->name('delete-product-category')->middleware(['auth:sanctum', 'verified']);

        });
});
