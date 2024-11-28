@props(['post'=>null])

@php
$method = $post ? 'POST' : 'GET';

@endphp
<form {{$attributes->class('space-y-4 flex flex-col')}} method="{{$method}}">
  @if($method != 'GET')
    @csrf
  @endif

 {{$slot}}
</form>