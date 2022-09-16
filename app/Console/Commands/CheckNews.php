<?php

namespace App\Console\Commands;

use App\Services\ArticleService;
use Illuminate\Console\Command;

class CheckNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check news';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        ArticleService::check();
        return 0;
    }
}
