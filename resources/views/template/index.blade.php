<x-layouts.app>
    <x-slot name="header">
       <x-h2>
           {{ __('Templates') }}
       </x-h2>
    </x-slot>

    <x-card class="space-y-4">
            <div class="flex justify-between">
                <x-button.link href="{{ route('template.create') }}">
                    {{ __('Create new template') }}
                </x-button.link>   
                <x-form 
                    :action="route('template.index')" 
                    x-data x-ref="form"
                    class="w-3/5 flex space-x-4 items-center"
                    flat
                >
                 <x-input.checkbox   
                    name="withTrash" 
                    @click="$refs.form.submit()"
                    :label="__('Show trash')"
                    value="1"
                    :checked="$withTrash"/>
                    <x-input.text name="search" :placeholder="__('Search')" :value="$search" class="w-full"/>
                </x-form>
            </div>
            <x-table :headers="['#', __('Name'), __('Actions')]">
                <x-slot name="body">
                        @foreach ($templates as $template)     
                        <tr>
                            <x-table.td class="w-1">{{ $template->id }}</x-table.td>
                            <x-table.td>{{ $template->name }}</x-table.td>
                               <x-table.td class="flex items-center space-x-4 w-20">
                                <x-button.link secondary :href="route('template.edit', $template)"> {{__('Edit')}} </x-button.link>
                                <x-button.link secondary :href="route('template.show', $template)"> {{__('Show')}} </x-button.link>
                               
                                @unless($template->trashed())
                                <div>
                                    <x-form 
                                    :action="route('template.destroy', $template)"
                                    delete
                                    flat
                                    onsubmit="return confirm('{{ __('Are you sure?')}}')"
                                >
                                </div>
                                   
                                    <x-button.secondary type="submit"> {{__('Delete')}} </x-button.secondary>
                                </x-form>
                                @else
                                <x-badge danger>{{__('Deleted')}}</x-badge>
                                
                                @endunless
                            </x-table.td>
                        </tr>
                        @endforeach  
                </x-slot>
            </x-table>
            {{$templates->links()}}
    </x-card>
</x-layouts.app>
