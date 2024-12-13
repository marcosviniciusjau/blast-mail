@props([
  'title',
  'info'=>null,
  'success'=> null,
  'warning'=>null,
  'danger'=>null
  ])


<!-- success Alert -->
<div @class([
  'relative w-full overflow-hidden rounded-md border bg-white text-neutral-600 dark:bg-neutral-950 dark:text-neutral-300',
  'border-green-500'=>$success,
  'border-sky-600' =>$info,
  'border-amber-600' =>$warning,
  'border-red-600' =>$danger,
]) role="alert">
  <div @class([
    'flex w-full items-center gap-2 p-4',
    'bg-green-600/10 text-green-600'=>$success,
    'bg-sky-600/10  text-sky-600'=>$info,
    'bg-amber-600/10  text-amber-600'=>$warning,
    'bg-red-600/10  text-red-600'=>$danger,
  ])>
      <div @class([
        'rounded-full p-1',
        'bg-green-500/15 text-green-500 '=>$success
      ])
        aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
          </svg>
      </div>
      <div class="ml-2">
          <h3 @class([
            'text-sm font-semibold',
            'text-green-500'=>$success,
            'text-sky-600'=>$info,
            'text-amber-600'=>$warning,
            'text-red-600'=>$danger,
          ])>{{$title}}</h3>
         @if($slot)
         <p class="text-xs font-medium sm:text-sm"{{$slot}}</p>
         @endif
      </div>
   
  </div>
</div>