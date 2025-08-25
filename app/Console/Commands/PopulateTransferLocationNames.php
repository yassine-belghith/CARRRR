<?php

namespace App\Console\Commands;

use App\Models\Transfer;
use Illuminate\Console\Command;

class PopulateTransferLocationNames extends Command
{
    protected $signature = 'transfers:populate-location-names';
    protected $description = 'Populate missing location names in transfers table';

    public function handle()
    {
        $this->info('Populating transfer location names...');
        
        $transfers = Transfer::with(['pickupDestination', 'dropoffDestination'])
            ->whereNull('pickup_location_name')
            ->orWhereNull('dropoff_location_name')
            ->get();

        $updated = 0;
        
        foreach ($transfers as $transfer) {
            $needsUpdate = false;
            
            // Update pickup location name
            if (!$transfer->pickup_location_name) {
                if ($transfer->pickupDestination) {
                    $transfer->pickup_location_name = $transfer->pickupDestination->name;
                    $needsUpdate = true;
                } elseif ($transfer->pickup_latitude && $transfer->pickup_longitude) {
                    $transfer->pickup_location_name = "Pickup ({$transfer->pickup_latitude}, {$transfer->pickup_longitude})";
                    $needsUpdate = true;
                }
            }
            
            // Update dropoff location name
            if (!$transfer->dropoff_location_name) {
                if ($transfer->dropoffDestination) {
                    $transfer->dropoff_location_name = $transfer->dropoffDestination->name;
                    $needsUpdate = true;
                } elseif ($transfer->dropoff_latitude && $transfer->dropoff_longitude) {
                    $transfer->dropoff_location_name = "Dropoff ({$transfer->dropoff_latitude}, {$transfer->dropoff_longitude})";
                    $needsUpdate = true;
                }
            }
            
            if ($needsUpdate) {
                $transfer->save();
                $updated++;
            }
        }
        
        $this->info("Updated {$updated} transfers with location names.");
        
        return 0;
    }
}
