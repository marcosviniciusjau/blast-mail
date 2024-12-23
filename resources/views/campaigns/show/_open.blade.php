<div class="space-y-4">
<x-form action="{{route('campaigns.show', ['campaign'=>$campaign->id, 'what'=> $what])}}" get>
  <x-input.text name="search" placelholder="{{ __('Search') }}" value="{{$search}}"/>
</x-form>

      <x-table :headers="['#', __('Name'), __('Opens'), __('Emails')]">
          <x-slot name="body">
            <tr>
              <x-table.td>a</x-table.td>
              <x-table.td>b</x-table.td>
              <x-table.td>c</x-table.td>
            </tr>
          </x-slot>
      </x-table>

  </div>
