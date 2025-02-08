<?php

namespace App\Jobs;

use Domain\Entities\Sale;
use Domain\Repositories\SaleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Job responsible for processing sales asynchronously.
 */
class ProcessSaleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Sale $sale;

    /**
     * Create a new job instance.
     *
     * @param Sale $sale
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Execute the job.
     *
     * @param SaleRepositoryInterface $saleRepository
     * @return void
     */
    public function handle(SaleRepositoryInterface $saleRepository): void
    {
        $saleRepository->save($this->sale);
    }
}
