<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-status';
    protected $description = 'Update event statuses to Completed, Ongoing, or Upcoming';

    /**
     * The console command description.
     *
     * @var string
     */

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
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->toDateString();
        DB::table('events')->update([
            'event_status' => DB::raw("
                CASE
                    WHEN event_date = '$currentDate' THEN 'Ongoing'
                    WHEN event_date < '$currentDate' THEN 'Completed'
                    WHEN event_date > '$currentDate' THEN 'Upcoming'
                END
            ")
        ]);

        $this->info('Event statuses updated successfully.');

    }
}
