@props(['category'])
<x-badge wire:navigate href="{{ route('posts.index',['category'=>$category->slug]) }}" 
    textColor="{{ $category->bg_color}}" 
    bgColor="{{ $category->text_color }}">
    {{ $category->title }}
</x-badge>