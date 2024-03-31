<?php

namespace App\Providers;

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

        // $secretManager = new SecretManagerServiceClient();

        // $secretName = "projects/341264949013/secrets/bucket-manager/versions/latest";
        // $response = $secretManager->accessSecretVersion($secretName);
        
        // $payload = $response->getPayload()->getData();
        
        // $keyfileData = json_decode($payload, true);

        // putenv("GOOGLE_APPLICATION_CREDENTIALS=".json_encode($keyfileData));
        // // Update the filesystem configuration directly
        // $config = config('filesystems.disks.gcs');
        // $config['key_file'] = $keyfileData;

        // // Replace the original configuration with the updated one
        // config(['filesystems.disks.gcs' => $config]);

        // //
    }
}
