<?php

namespace App\Console\Commands;

use App\Services\Front\MusicService;
use Illuminate\Console\Command;

class DeleteExpiredMusicsCommand extends Command
{
    /**
     * @param MusicService $musicService
     */
    public function __construct(private MusicService $musicService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expired-musics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired musics command';


    public function handle()
    {
        return $this->musicService->deleteExpiredMusics();
    }
}
