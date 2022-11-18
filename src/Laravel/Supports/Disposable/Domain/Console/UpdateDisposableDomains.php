<?php

namespace Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Console;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Console\Command;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\Contracts\DomainFetcher;
use Simtabi\Enekia\Laravel\Validators\Disposable\Domain\DisposableDomain;

class UpdateDisposableDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enekia:update:disposable-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates to the latest disposable email domains list';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Simtabi\Enekia\Laravel\Validators\Disposable\Domain\DisposableDomain  $disposable
     * @return  void
     */
    public function handle(Config $config, DisposableDomain $disposable)
    {
        $this->line('Fetching from source...');

        $fetcher = $this->laravel->make(
            $fetcherClass = $config->get('enekia.disposable_domains.fetcher')
        );

        if (! $fetcher instanceof DomainFetcher) {
            $this->error($fetcherClass . ' should implement ' . DomainFetcher::class);
            return 1;
        }

        $data = $this->laravel->call([$fetcher, 'handle'], [
            'url' => $config->get('enekia.disposable_domains.source'),
        ]);

        $this->line('Saving response to storage...');

        if ($disposable->saveToStorage($data)) {
            $this->info('Disposable domains list updated successfully.');
            $disposable->bootstrap();
            return 0;
        } else {
            $this->error('Could not write to storage ('.$disposable->getStoragePath().')!');
            return 1;
        }
    }
}
