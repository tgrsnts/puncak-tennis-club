<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Illuminate\Console\Command;

class SweepExpiredPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:sweep-expired-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = 0;

        Payment::where('status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->chunkById(200, function ($rows) use (&$count) {
                foreach ($rows as $p) {
                    $p->status = 'expired';
                    $p->save();

                    if ($p->booking) {
                        // gunakan status yang kamu pakai di domain (cancelled / expired)
                        $p->booking->status = 'cancelled';
                        $p->booking->save();
                    }
                    $count++;
                }
            });

        $this->info("Expired swept: {$count}");
        return self::SUCCESS;
    }
}
