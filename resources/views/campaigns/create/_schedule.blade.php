<div class="flex flex-col gap-4">
    <x-alert danger :title="__('Your campaign to be send')" />

    <div>
        <div>De ------@---.com</div>
        <div>Para #count</div>
        <div>Assunto {{ $data['subject'] }}</div>
        <div>Template</div>
    </div>
    </hr>

    <div>
        <x-input.label :value="__('Schedule Delivery')" />
        <div class="flex flex-col gap-2 mt-2">
            <x-input.radio id="send_now" name="sendWhen" value="now" checked>
                {{ __('Send now') }}
            </x-input.radio>
            <x-input.radio id="send_later" name="sendWhen" value="later">
                {{ __('Send later') }}
            </x-input.radio>
        </div>

    </div>
    <div>
        <x-input.label for="send_at" :value="__('Sent at')" />
        <x-input.text id="send_at" class="block mt-1 w-full" type="date" name="send_at" :value="old('send_at', $data['send_at'])"
            autofocus />
        <x-input.error :messages="$errors->get('send_at')" class="mt-2" />
    </div>

</div>
