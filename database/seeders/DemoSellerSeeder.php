<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seller;
use App\Models\User;

class DemoSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the demo seller user
        $demoSeller = User::where('email', 'seller@demo.com')->first();
        
        if ($demoSeller) {
            // Create a seller record for the demo seller
            Seller::updateOrCreate(
                ['user_id' => $demoSeller->id],
                [
                    'commission_rate' => 10.00, // 10% commission
                    'bkash_number' => null
                ]
            );
            
            $this->command->info("Demo seller added to sellers table with user ID: {$demoSeller->id}");
        } else {
            $this->command->error('Demo seller user not found!');
        }
    }
}
