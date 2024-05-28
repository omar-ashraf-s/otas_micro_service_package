<?php

namespace Solutionplus\MicroService\Console\Commands;

use Illuminate\Console\Command;
use Solutionplus\MicroService\Helpers\MsHttp;

class MicroServiceEstablishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ms:establish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Establish connection with another microservice';

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
        $destinationMicroserviceName = $this->ask('What is the destination name?');
        $destinationMicroserviceOrigin = $this->ask('What is the destination origin?');

        if ($destinationMicroserviceName == null || $destinationMicroserviceOrigin == null) {
            $this->warn('Connection not established!!!');
            return Command::FAILURE;
        }

        $response = MsHttp::establish($destinationMicroserviceName, $destinationMicroserviceOrigin);

        if (! $response->ok()) {
            $this->warn('Failed to establish. response code:' . $response->status());
            return Command::FAILURE;
        }

        $this->info('Connection established successfully');

        return Command::SUCCESS;
    }
}
