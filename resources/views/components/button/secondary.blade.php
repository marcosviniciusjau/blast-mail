@props(['danger'=> null])

<button {{ $attributes
->merge(['type' => 'button']) 
->class([
        'inline-flex items-center px-4 py-2 border font-semibold text-xs uppercase tracking-widest focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800',
        'bg-white dark:bg-red-800  border-red-300 dark:border-red-500 rounded-md text-red-700 dark:text-red-300 shadow-sm hover:bg-red-50 dark:hover:bg-red-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150'=> $danger,
]), }}>
    {{ $slot }}
</button>
