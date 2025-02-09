@component('mail::message')
    # Daily Sales Report

    Hello, here is your sales summary for today.

    @component('mail::panel')
        {{ $report }}
    @endcomponent

    Thank you,<br>
    {{ config('app.name') }}
@endcomponent
