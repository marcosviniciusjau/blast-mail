<x-layouts.app>
    <x-slot name="header">
       <x-h2>
           {{ __('Email list') }}
       </x-h2>
    </x-slot>

    <x-card>
        @forelse ($emailLists as $lists)
        @empty
        <div class="flex justify-center">
            <x-link-button href="{{ route('email-list.create') }}">
                {{ __('Add email list') }}
            </x-link-button>
        </div>
        @endforelse
    </x-card>
</x-layouts.app>
