<?php

namespace App\Providers;

use Botble\Setting\Facades\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
// use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

       if ($this->app->environment('production')) {
           URL::forceScheme('https');
       }

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $encryptedWithIv = getenv("KEY_FILE");
        // Decrypt
        list($encryptedData, $iv) = explode('::', base64_decode($encryptedWithIv), 2);
        $iv = base64_decode($iv); // Decode the IV back
        $decryptedString = openssl_decrypt($encryptedData, 'aes-256-cbc', "Amir208079@", 0, $iv);

        // Convert back to object
        $decrypted = json_decode($decryptedString, true); // Use true to get it as an associative array

        // Debug
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".json_encode($decrypted));

        $config = config('filesystems.disks.gcs');
        $config['key_file'] = $decrypted;
        config(['filesystems.disks.gcs' => $config]);
        $this->app->booted(function () {
            $this->_registerMailConfig();
        });
    }

    private function _registerMailConfig()
    {
        $mails = collect(json_decode(Setting::get("mails"), true));
        if ($mails->count()) {
            // if ($mails->has('smtp')) config(['mail.mailers.smtp' => collect(config('mail.mailers.smtp'))->merge($mails->get('smtp'))->toArray()]);
            if ($mails->has('smtp_pec')) config(['mail.mailers.smtp_pec' => collect(config('mail.mailers.smtp_pec'))->merge($mails->get('smtp_pec'))->toArray()]);
        }
    }
}
