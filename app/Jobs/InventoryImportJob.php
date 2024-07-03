<?php

namespace App\Jobs;

use App\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InventoryImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $arrayToInsert;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($arrayToInsert)
    {
        $this->arrayToInsert = $arrayToInsert;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            Inventory::insert($this->arrayToInsert);

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}


