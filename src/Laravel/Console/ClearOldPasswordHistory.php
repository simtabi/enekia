<?php

namespace Simtabi\Enekia\Laravel\Console;

use Illuminate\Console\Command;

class ClearOldPasswordHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enekia:clear:old-password-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Old Password History';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Getting Users old passwords...');

        $model = config('enekia.password_history.observer.model');

        if (class_exists($model))
        {
            $model::chunk(100, function ($users) {
                $users->each->deletePasswordHistory();
            });
        }

        $this->info('Old Passwords Cleared...');
    }
}