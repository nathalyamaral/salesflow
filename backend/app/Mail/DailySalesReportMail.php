<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySalesReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $report;

    /**
     * Create a new email instance.
     */
    public function __construct(string $report)
    {
        $this->report = $report;
    }

    /**
     * Build the email message.
     */
    public function build(): self
    {
        return $this->subject('Your Daily Sales Report')
            ->markdown('emails.daily_sales_report', [
                'report' => $this->report,
            ]);
    }
}
