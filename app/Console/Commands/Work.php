<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class Work extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Mail to all user';

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
        $user = User::all();
        
        foreach($user as $u)
        {
            Mail::raw("Work hard to get success",function($mail) use ($u)
            {
                $mail->from('vishal.c.addweb@gmail.com');
                $mail->to($u->email)->subject('currently you are working on jetstream'); 
            });
        }
        $this->info('work message send Successfully');
    }
}
