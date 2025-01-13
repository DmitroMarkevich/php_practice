<?php

namespace App\Console\Commands;

use App\Models\EmailVerificationToken;
use Illuminate\Console\Command;

class CleanExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired email verification tokens from the database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = EmailVerificationToken::where('expires_at', '<', now())->delete();

        $this->info("Successfully deleted $count expired tokens.");
    }
}
