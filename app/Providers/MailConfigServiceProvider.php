<?php
/**
 * Created by PhpStorm.
 * Filename: MailConfigServiceProvider.php
 * User: Thang Nguyen Nhan
 * Date: 2/10/2020
 * Time: 3:15 PM
 */

namespace App\Providers;

use App\Libs\FunctionLib;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $config_from_db = DB::table('__configs')->where('key', 'config')->first();
        $config_from_db = !empty($config_from_db->value) ? json_decode($config_from_db->value, true) : null;
        if(!empty($config_from_db)) {
            $config = array(
                'driver' => @$config_from_db['mail_driver'] ?? 'sendmail',
                'host' => @$config_from_db['mail_host'],
                'port' => @$config_from_db['mail_port'],
                'from' => array('address' => @$config_from_db['mail_from_address'] ?? 'abc@abc.com', 'name' => @$config_from_db['mail_from_name'] ?? 'abc@abc.com'),
                'encryption' => @$config_from_db['mail_encryption'] ?? 'tsl',
                'username' => @$config_from_db['mail_username'],
                'password' => @$config_from_db['mail_password'],
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );
            Config::set('mail', $config);
        }
    }
}