<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\DeliveryBoy;
use Carbon\Carbon;

class AssignOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically assigning orders to delivery boys';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('status', 'pending')->get();
        if ($orders->isEmpty()) {
            $this->info('No pending orders.');
            return;
        }
        $this->info('Pending Orders:');
            foreach ($orders as $order) {
             $this->line("Order #{$order->order_number}");
        }
        $deliveryBoys = DeliveryBoy::all();
        foreach ($deliveryBoys as $boys) {
                $activeAssignments = $boys->orders()
                ->where('status', 'assigned')
                ->where('assigned_at', '>=', Carbon::now()->subMinutes($boys->delivery_duration))
                ->count();
        
        if ($activeAssignments < $boys->capacity) {
            $availableSlots = $boys->capacity - $activeAssignments;
            $ordersToAssign = $orders->splice(0, $availableSlots);
            foreach ($ordersToAssign as $order) {
                $order->update([
                    'delivery_boy_id' => $boys->id,
                    'status' => 'assigned',
                    'assigned_at' => Carbon::now(),
                ]);
                $this->info("Assigned Order #{$order->order_number} to Delivery Boy {$boys->name}");
            }
        }
        if ($orders->isEmpty()) {
            break;
        }
        }
        $this->info('Order assignment completed.');        
    }
}