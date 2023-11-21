@props(['bgColor','textColor'])

@php
    $textColor=match ($textColor) {
         'gray'=> 'text-gray-800',
         'blue' => 'text-blue-800',
         'yellow' => 'text-yellow-800',
         'red' => 'text-red-800',
        default=>'text-red-600'
    };
    $bgColor=match ($bgColor) {
         'gray'=> 'bg-gray-300',
         'blue' => 'bg-blue-300',
         'yellow' => 'bg-yellow-300',
         'red' => 'bg-red-300',
        default=>'bg-red-100'
    };
@endphp

<button {{ $attributes }}  class="{{$textColor}} {{ $bgColor }} rounded-xl px-3 py-1 text-base">
    {{ $slot }}
</button>