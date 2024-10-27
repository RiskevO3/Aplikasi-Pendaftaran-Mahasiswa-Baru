@props(['spinner-color'=>'text-red-700'])
<div {{ $attributes->merge(['class' => 'flex fixed bg-black bg-opacity-50 z-10 h-full w-full items-center justify-center']) }}>
    <div class="flex items-center content-center">
      <x-icons.spinner-icon class='text-red-700'/>
    </div>
</div>
