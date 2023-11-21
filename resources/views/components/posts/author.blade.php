@props(['author','size'])

@php
    
    $imageSize=match ($size ?? null) {
         's'=>"w-7 h-7",
         'm'=>'w-10 h-10' ,
         'l'=>" w-10 h-10",
         default=>"w-7 h-7",
    };
    $textSize=match ($size ?? null) {
         's'=>"text-xs",
         'm'=>'text-m' ,
         'l'=>"text-xl",
         default=>"text-xs",
    };

@endphp
    <img class="{{ $imageSize }} rounded-full mr-3"
    src="{{ $author->profile_photo_url }}"
    alt="avatar">
<span class="mr-1 {{ $textSize }}">{{ $author->name }}</span>
