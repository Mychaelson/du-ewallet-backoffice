<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackofficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('backoffice.user')->truncate();
        DB::table('backoffice.roles')->truncate();
        DB::table('backoffice.module')->truncate();

        DB::table('backoffice.user')->insert([
            'id' => 1,
            'name' => 'admin',
            'password' => 'RQBBmddjxVtTlpccUqg=',
            'fullname' => 'admin',
            'nickname' => 'admin',
            'role' => 1,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 1,
            'parent_id' => 0,
            'mod_name' => 'Wallet User',
            'mod_alias' => 'wallet-user',
            'mod_order' => 1,
            'icon' => 'flaticon-users',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 2,
            'parent_id' => 1,
            'mod_name' => 'All Users',
            'mod_alias' => 'all-user-list',
            'permalink' => 'user/list',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 3,
            'parent_id' => 1,
            'mod_name' => 'Groups',
            'mod_alias' => 'user-groups',
            'permalink' => 'user/groups',
            'mod_order' => 2,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 4,
            'parent_id' => 1,
            'mod_name' => 'Statistic',
            'mod_alias' => 'user-statistic',
            'permalink' => 'user/statistic',
            'mod_order' => 3,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 5,
            'parent_id' => 1,
            'mod_name' => 'Blacklist',
            'mod_alias' => 'user-blacklist',
            'permalink' => 'user/blacklist',
            'mod_order' => 4,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 6,
            'parent_id' => 1,
            'mod_name' => 'Watchlist',
            'mod_alias' => 'user-watchlist',
            'permalink' => 'user/watchlist',
            'mod_order' => 5,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 7,
            'parent_id' => 1,
            'mod_name' => 'KYC',
            'mod_alias' => 'user-kyc',
            'permalink' => 'user/kyc',
            'mod_order' => 6,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 8,
            'parent_id' => 1,
            'mod_name' => 'KYC Log',
            'mod_alias' => 'user-kyclog',
            'permalink' => 'user/kyclog',
            'mod_order' => 7,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 9,
            'parent_id' => 1,
            'mod_name' => 'Close Account',
            'mod_alias' => 'user-closeaccount',
            'permalink' => 'user/closeaccount',
            'mod_order' => 8,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 10,
            'parent_id' => 1,
            'mod_name' => 'Close Log',
            'mod_alias' => 'user-closelog',
            'permalink' => 'user/closelog',
            'mod_order' => 9,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 11,
            'parent_id' => 0,
            'mod_name' => 'Wallet',
            'mod_alias' => 'wallet',
            'mod_order' => 1,
            'icon' => 'flaticon-coins',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 12,
            'parent_id' => 11,
            'mod_name' => 'All Emoney Wallets',
            'mod_alias' => 'wallet-emoney',
            'permalink' => 'wallet/emoney',
            'mod_order' => 2,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 13,
            'parent_id' => 11,
            'mod_name' => 'Transaction Histories',
            'mod_alias' => 'wallet-history',
            'permalink' => 'wallet/history',
            'mod_order' => 3,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 14,
            'parent_id' => 11,
            'mod_name' => 'Wallet Statistics',
            'mod_alias' => 'wallet-statistics',
            'permalink' => 'wallet/statistics',
            'mod_order' => 4,
        ]);

        DB::table('backoffice.module')->insert([
        'modid' => 15,
            'parent_id' => 11,
            'mod_name' => 'Switch Fee By Bank',
            'mod_alias' => 'wallet-switch',
            'permalink' => 'wallet/switch',
            'mod_order' => 5,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 16,
            'parent_id' => 11,
            'mod_name' => 'Wallet Setting',
            'mod_alias' => 'wallet-setting',
            'permalink' => 'wallet/setting',
            'mod_order' => 6,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 17,
            'parent_id' => 11,
            'mod_name' => 'Wallet Topup Unique Code',
            'mod_alias' => 'wallet-unique',
            'permalink' => 'wallet/unique',
            'mod_order' => 7,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 18,
            'parent_id' => 11,
            'mod_name' => 'Wallet Label',
            'mod_alias' => 'wallet-label',
            'permalink' => 'wallet/label',
            'mod_order' => 8,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 19,
            'parent_id' => 11,
            'mod_name' => 'Wallet Receipt Editor',
            'mod_alias' => 'wallet-receipt',
            'permalink' => 'wallet/receipt',
            'mod_order' => 9,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 20,
            'parent_id' => 11,
            'mod_name' => 'Wallet In/Out',
            'mod_alias' => 'wallet-inout',
            'permalink' => 'wallet/inout',
            'mod_order' => 10,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 21,
            'parent_id' => 11,
            'mod_name' => 'Wallet Reversal History',
            'mod_alias' => 'wallet-reversal-history',
            'permalink' => 'wallet/reversal-history',
            'mod_order' => 11,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 22,
            'parent_id' => 0,
            'mod_name' => 'Ticket',
            'mod_alias' => 'ticket',
            'permalink' => '',
            'icon' => 'flaticon-envelope',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 23,
            'parent_id' => 22,
            'mod_name' => 'All Ticket',
            'mod_alias' => 'all-ticket-list',
            'permalink' => 'ticket/list',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 24,
            'parent_id' => 22,
            'mod_name' => 'Ticket Category',
            'mod_alias' => 'all-ticket-category-list',
            'permalink' => 'ticket/category',
            'mod_order' => 2,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 25,
            'parent_id' => 0,
            'mod_name' => 'Banner',
            'mod_alias' => 'banner',
            'permalink' => 'banner/list',
            'mod_order' => 1,
            'icon' => 'fa fa-flag',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 26,
            'parent_id' => 0,
            'mod_name' => 'Documents',
            'mod_alias' => 'documents',
            'permalink' => '',
            'mod_order' => 1,
            'icon' => 'fa fa-folder',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 27,
            'parent_id' => 26,
            'mod_name' => 'Yamisok Pay Documents',
            'mod_alias' => 'all-documents',
            'permalink' => 'docs',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 28,
            'parent_id' => 26,
            'mod_name' => 'Help',
            'mod_alias' => 'help',
            'permalink' => 'help/category',
            'mod_order' => 1,
        ]);
        DB::table('backoffice.module')->insert([
            'modid' => 29,
            'parent_id' => 26,
            'mod_name' => 'Report',
            'mod_alias' => 'report',
            'permalink' => 'report',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 30,
            'parent_id' => 0,
            'mod_name' => 'OTP',
            'mod_alias' => 'otp-active',
            'permalink' => 'otp/active',
            'mod_order' => 1,
            'icon' => 'fa fa-key',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 31,
            'parent_id' => 0,
            'mod_name' => 'Language',
            'mod_alias' => 'language',
            'permalink' => '',
            'mod_order' => 1,
            'icon' => 'flaticon-placeholder-1',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 32,
            'parent_id' => 31,
            'mod_name' => 'Project',
            'mod_alias' => 'langs-list_project',
            'permalink' => 'langs/list_project',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 33,
            'parent_id' => 31,
            'mod_name' => 'Lang',
            'mod_alias' => 'langs-list_lang',
            'permalink' => 'langs/list_lang',
            'mod_order' => 2,
        ]);



        DB::table('backoffice.module')->insert([
            'modid' => 34,
            'parent_id' => 0,
            'mod_name' => 'Promotion',
            'mod_alias' => 'promotion',
            'permalink' => '',
            'mod_order' => 1,
            'icon' => 'fa fa-tags',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 35,
            'parent_id' => 34,
            'mod_name' => 'Cashback',
            'mod_alias' => 'promotion-cashback',
            'permalink' => 'promotion/cashback',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 36,
            'parent_id' => 34,
            'mod_name' => 'Mission',
            'mod_alias' => 'promotion-mission',
            'permalink' => 'promotion/mission',
            'mod_order' => 2,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 37,
            'parent_id' => 34,
            'mod_name' => 'Catalogue',
            'mod_alias' => 'promotion-catalogue',
            'permalink' => 'promotion/catalogue',
            'mod_order' => 3,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 38,
            'parent_id' => 0,
            'mod_name' => 'User',
            'mod_alias' => 'auth_user',
            'permalink' => 'auth_user',
            'mod_order' => 1,
            'icon' => 'flaticon2-user',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 39,
            'parent_id' => 0,
            'mod_name' => 'Media',
            'mod_alias' => 'file-list',
            'permalink' => 'file/list',
            'mod_order' => 1,
            'icon' => 'flaticon2-image-file',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 40,
            'parent_id' => 0,
            'mod_name' => 'Setting',
            'mod_alias' => 'setting',
            'permalink' => '',
            'mod_order' => 1,
            'icon' => 'fa fa-cog',
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 41,
            'parent_id' => 40,
            'mod_name' => 'Param',
            'mod_alias' => 'setting-params',
            'permalink' => 'setting/params',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 42,
            'parent_id' => 40,
            'mod_name' => 'Master Jobs',
            'mod_alias' => 'setting-jobs',
            'permalink' => 'setting/master-jobs',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 43,
            'parent_id' => 40,
            'mod_name' => 'Master Roles',
            'mod_alias' => 'setting-roles',
            'permalink' => 'setting/master_role',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 44,
            'parent_id' => 40,
            'mod_name' => 'Master Activity',
            'mod_alias' => 'setting-master_activity',
            'permalink' => 'setting/master-activity',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 45,
            'parent_id' => 40,
            'mod_name' => 'Debt Collection',
            'mod_alias' => 'setting-debt-collection',
            'permalink' => 'setting/debt_collection',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 46,
            'parent_id' => 0,
            'mod_name' => 'PPOB',
            'mod_alias' => 'ppob',
            'permalink' => '',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 48,
            'parent_id' => 46,
            'mod_name' => 'Product Category',
            'mod_alias' => 'product_category',
            'permalink' => 'ppob/product_category',
            'mod_order' => 1,
        ]);

        DB::table('backoffice.module')->insert([
            'modid' => 49,
            'parent_id' => 46,
            'mod_name' => 'Product',
            'mod_alias' => 'product',
            'permalink' => 'ppob/product',
            'mod_order' => 1,
        ]);

        $totalModules = implode(',', range(1, 50));
        DB::table('backoffice.roles')->insert([
            'id' => 1,
            'name' => 'Superadmin',
            'role' => '{"view":"'.$totalModules.'","create":"'.$totalModules.'","alter":"'.$totalModules.'","drop":"'.$totalModules.'"}',
        ]);

    }
}
