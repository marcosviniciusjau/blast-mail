<x-mail::message>
    {!! $body !!}

    {{ __('Thanks') }},<br>

    {{ config('app.name') }}
    <h1>não to confiando!</h1>
    <img src="{{ route('tracking.openings', $mail) }}" style="display:none;" />
</x-mail::message>

