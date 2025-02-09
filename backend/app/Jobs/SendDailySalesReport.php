<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySalesReportMail;
use Domain\Repositories\SellerRepositoryInterface;

class SendDailySalesReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(SellerRepositoryInterface $sellerRepository): void
    {
        $sellers = $sellerRepository->findAll();

        if (empty($sellers)) {
            \Log::info("No sellers found to send reports.");
            return;
        }

        foreach ($sellers as $seller) {
            $response = Http::get(env('APP_URL') . "/api/sales/{$seller->getId()}");

            if ($response->failed()) {
                \Log::error("Failed to fetch sales for seller {$seller->getId()} ({$seller->getEmail()})");
                continue;
            }

            $sales = $response->json();

            if (empty($sales)) {
                \Log::info("No sales found for seller {$seller->getId()} ({$seller->getEmail()})");
                continue;
            }

            $totalAmount = array_sum(array_column($sales, 'amount'));

            $report = "Sales Report - " . now()->toDateString() . "\n\n";
            $report .= "Seller: {$seller->getName()} ({$seller->getEmail()})\n";
            $report .= "Total Sales: $ {$totalAmount}\n\n";
            $report .= "Sales Details:\n";

            foreach ($sales as $sale) {
                $report .= "- Amount: $ {$sale['amount']}, Commission: $ {$sale['commission']}, Date: {$sale['date']}\n";
            }

            Mail::to($seller->getEmail())->send(new DailySalesReportMail($report));

            \Log::info("Sales report sent to {$seller->getEmail()}.");
        }
    }
}
