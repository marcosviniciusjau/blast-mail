@props([
  'post'=>null,
  'flat' => false,
   'delete'=>null
  ])

@php
$method = ($post or $delete) ? 'POST' : 'GET' ;

@endphp

<form {{$attributes->class(['gap-4 flex flex-col' => !$flat])}} method="{{$method}}">
  @if($method != 'GET')
    @csrf
  @endif

  @if($delete)
    @method('DELETE')
  @endif

 {{$slot}}
</form>