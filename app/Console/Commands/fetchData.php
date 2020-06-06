<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp;
use GuzzleHttp\Client;

class fetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:pairs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pair to pairs table in database ';

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
        //create the handle function for the command
        $client = new GuzzleHttp\Client();
        $result = $client->request('GET','https://api.crex24.com/v2/public/tickers?instrument=BTC-USDT');
        return $result->getBody(); 
        $clients = json_decode($result, true);
        

        foreach($clients as $client) {
            Pair::updateOrCreate([
                'pair' => $client->instrument,
            ],
            [
                
                'pair' => $client->instrument,
                'price' => $client->last
            ]);
        }

    }
}
