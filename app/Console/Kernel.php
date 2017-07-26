<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        try{
            $schedule->call(function(){
                $this->getLotteryFromApi();
            })->everyMinute();
        }catch(\Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }


    private function getLotteryFromApi(){
        $url = 'http://f.apiplus.net/ssq-1.json';
        $res = json_decode(file_get_contents(urldecode($url)),true);
        $data = $res['data'];
        foreach($data as $value) {
            $lottery = new \App\Ssq();
            $lottery->periods = $value['expect'];
            $lottery->numbers = $value['opencode'];
            $numbers = explode('+', $value['opencode']);
            $red = explode(',', $numbers[0]);
            $lottery->r1 = array_shift($red);
            $lottery->r2 = array_shift($red);
            $lottery->r3 = array_shift($red);
            $lottery->r4 = array_shift($red);
            $lottery->r5 = array_shift($red);
            $lottery->r6 = array_shift($red);
            $lottery->b1 = $numbers[1];
            $lottery->save();
        }
    }
}
