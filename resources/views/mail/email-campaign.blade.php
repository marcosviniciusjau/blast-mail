<x-mail::message>
{!! $body !!}
    {{ __('Thanks') }},<br>
    <img src="{{ route('tracking.openings', $mail) }}"  style="display:none;" />
    {{ config('app.name') }}
</x-mail::message>

