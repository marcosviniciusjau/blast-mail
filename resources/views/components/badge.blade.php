@props(['danger'=> null])

<span {{$attributes->class([
  'rounded-xl w-fit border px-2 py-1 text-xs font-medium text-slate-100 dark:text-slate-100',
  'border-red-700 bg-red-700 dark:border-red-600 dark:bg-red-600'=> $danger
])}}>
{{$slot}}
</span>