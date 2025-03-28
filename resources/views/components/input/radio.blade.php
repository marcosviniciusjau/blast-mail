@props(['id'])


<div class="flex items-center justify-start gap-2 font-medium text-neutral-600 has-[:disabled]:opacity-75 dark:text-neutral-300">
<input id={{{$id}}} type="radio"
    class="before:content[''] relative h-4 w-4 appearance-none rounded-full border border-slate-300 bg-neutral-50 before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-1.5 before:w-1.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full before:bg-neutral-100 checked:border-black checked:bg-black checked:before:visible focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-neutral-800 checked:focus:outline-black disabled:cursor-not-allowed dark:border-neutral-700 dark:bg-neutral-900 dark:before:bg-black dark:checked:border-white dark:checked:bg-white dark:focus:outline-neutral-300 dark:checked:focus:outline-white"
    {{$attributes}}>
<label for={{{$id}}} class="text-sm">{{$slot}}</label>
</div>