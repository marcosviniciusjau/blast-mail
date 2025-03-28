<div class="space-y-4">
<x-form action="{{route('campaigns.show', ['campaign'=>$campaign->id, 'what'=> $what])}}" get>
  <x-input.text name="search" placelholder="{{ __('Search') }}" :value="$search"/>
</x-form>

      <x-table :headers="[ __('Name'), __('Clicks'), __('Emails')]">
          <x-slot name="body">
            @foreach ($query as $item)
            <tr>
              <x-table.td>{{$item->subscriber->name}}</x-table.td>
              <x-table.td>{{$item->clicks}}</x-table.td>
              <x-table.td>{{$item->subscriber->email}}</x-table.td>
            </tr>
            @endforeach
           
          </x-slot>
      </x-table>
  {{$query->links()}}
  </div>
