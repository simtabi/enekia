<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Console;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\Contracts\PhoneNumberFetcher;
use Simtabi\Enekia\Laravel\Validators\Disposable\PhoneNumber\DisposablePhoneNumber;

class UpdateDisposablePhoneNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enekia:update:disposable-phone-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates to the latest disposable phone numbers list';

    /**
     * Execute the console command.
     *
     * @param Config $config
     * @param DisposablePhoneNumber $disposable
     * @return  void
     * @throws BindingResolutionException
     */
    public function handle(Config $config, DisposablePhoneNumber $disposable)
    {
        $this->line('Fetching from source...');

        $fetcher = $this->laravel->make(
            $fetcherClass = $config->get('disposable-phone.fetcher')
        );

        if (! $fetcher instanceof PhoneNumberFetcher) {
            $this->error($fetcherClass . ' should implement ' . PhoneNumberFetcher::class);
            return 1;
        }

        $data = $this->laravel->call([$fetcher, 'handle'], [
            'url' => $config->get('disposable-phone.source'),
        ]);

        $this->line('Saving response to storage...');

        if ($disposable->saveToStorage($data)) {
            $this->info('Disposable numbers list updated successfully.');
            $disposable->bootstrap();
            return 0;
        } else {
            $this->error('Could not write to storage ('.$disposable->getStoragePath().')!');
            return 1;
        }
    }
}
