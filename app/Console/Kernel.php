<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

use App\Console\Commands\Work;
use App\Models\Todo;
use App\Models\User;
use App\Jobs\SendEmailJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Work::class,
    ];

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Kolkata';
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        //$schedule->command('work:update')->everyMinute();
        
        //$schedule->command(Work::class)->everyMinute();
        
        // $schedule->call(function () {
        //     Todo::where('title', '=', 'jwt')
        //         ->get()
        //         ->each
        //         ->delete();
        // })->everyMinute();

        // $schedule->call(function () {
        //     DB::table('sctable')->truncate();
        // })->everyMinute();
        
        // $schedule->job(new SendEmailJob)->everyMinute();
        
        //$schedule->job(new SendEmailJob,'SendEmailJob','database')->everyMinute();
        
        //$schedule->job(new SendEmailJob)->yearlyOn(6, 2, '17:29');
        
        //$schedule->job(new SendEmailJob)->weekly()->wednesdays()->at('17:43');

        //$schedule->job(new SendEmailJob)->everyMinute()->days([3]);

        //$schedule->job(new SendEmailJob)->everyMinute()->days([Schedule::WEDNESDAY]);
        
        $schedule->job(new SendEmailJob)->everyMinute()->when(function () {
            return false;
        });

        $schedule->job(new SendEmailJob)->everyMinute()->skip(function () {
            return true;
        });

        //$schedule->job(new SendEmailJob)->everyMinute()->withoutOverlapping();

        $filePath = "/var/www/html/laravel/st.txt";
        
        //$schedule->command('work:update')->everyMinute()->sendOutputTo($filePath);
        
        //$schedule->command('work:update')->everyMinute()->appendOutputTo($filePath);
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
