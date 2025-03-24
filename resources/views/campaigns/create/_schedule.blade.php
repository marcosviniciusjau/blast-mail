<div class="flex flex-col gap-4">
    <x-alert success :title="__('Your campaign is ready to be send!')" />

    <div class="space-y-1">
        <div>{{ __('From') }}: {{ config('mail.from.address') }}</div>
        <div>{{ __('To') }}: <x-badge>{{ $countEmails }} emails</x-badge></div>
        <div>{{ __('Subject') }}: {{ $data['subject'] }}</div>
        <div>{{ __('Template') }}: <x-badge>{{ $template }}</x-badge></div>
    </div>

    <hr class="my-3 opacity-20" />

    <div x-data="{ show: '{{ data_get($data, "send_when") }}' }">
        <x-input.label :value="__('Schedule Delivery')" />

        <div class="flex flex-col gap-2 mt-2">
            <x-input.radio id="send_now" name="send_when" value="now" x-model="show">{{ __('Send Now') }}</x-input.radio>
            <x-input.radio id="send_later" name="send_when" value="later" x-model="show">{{ __('Send Later') }}</x-input.radio>
        </div>
    </div>
</div>