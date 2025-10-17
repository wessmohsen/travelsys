<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Trip;

class ShowTrips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trips:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all trips from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $trips = Trip::all(['name', 'location', 'price']);

        if ($trips->isEmpty()) {
            $this->error('No trips found in the database.');
            return;
        }

        $this->info("Found {$trips->count()} trips:");
        $this->newLine();

        $data = $trips->map(fn($t) => [
            'Name' => $t->name,
            'Location' => $t->location,
            'Price' => '$' . number_format($t->price, 2)
        ])->toArray();

        $this->table(['Name', 'Location', 'Price'], $data);
    }
}
