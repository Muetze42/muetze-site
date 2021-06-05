@php $trim = !(isset($attributes['trim']) && $attributes['trim'] != true); @endphp
@if(isset($attributes['file']))
    {{ parseMarkdownFile($attributes['file'], $trim) }}
@else
    {{ parseMarkdown($slot, $trim) }}
@endif
