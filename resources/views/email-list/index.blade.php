<x-layouts.app>
    <x-slot name="header">
       <x-h2>
           {{ __('Email list') }}
       </x-h2>
    </x-slot>

    <x-card class="space-y-4">
       
        @unless ($emailLists->isEmpty() && blank($search))
            <div class="flex justify-between">
                <x-button.link href="{{ route('email-list.create') }}">
                    {{ __('Create a new email list') }}
                </x-button.link>   
                <x-form :action="route('email-list.index')" class="w-2/5">
                    <x-input.text name="search" :placeholder="__('Search')" :value="$search"/>
                </x-form>
            </div>
            <x-table :headers="['#', __('Email List'), __('Subscribers'), __('Actions')]">
                <x-slot name="body">
                        @foreach ($emailLists as $list)     
                        <tr>
                            <x-table.td>{{ $list->id }}</x-table.td>
                            <x-table.td>{{ $list->title }}</x-table.td>
                            <x-table.td>{{ $list->subscribers_count }}</x-table.td>
                        </tr>
                        @endforeach  
                </x-slot>
            </x-table>
            {{$emailLists->links()}}
            @else
            <div class="flex justify-center">
                <x-button.link href="{{ route('email-list.create') }}">
                    {{ __('Add email list') }}
                </x-button.link>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
