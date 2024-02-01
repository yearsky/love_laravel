@props(['value', 'readonly' => false,'name'])

<x-text-input type="text" class="mt-1 block w-full disabled:bg-slate-50 read-only:text-slate-500 read-only:bg-red-500 read-only:border-slate-200 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none bg-slate-400" :value="$value" :readonly="$readonly ? 'readonly' : 'disabled' :name=" $name" " />