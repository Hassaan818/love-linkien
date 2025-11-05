<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Checklist;
use Carbon\Carbon;

class DeactivateOldChecklists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checklist:deactivate-old-checklists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate checklists where the task_date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $affected = Checklist::where('task_date', '<', $today)
            ->where('status', 1)
            ->update(['status' => 0]);

        $this->info("{$affected} checklist(s) deactivated successfully.");
        return 0;
    }
}
