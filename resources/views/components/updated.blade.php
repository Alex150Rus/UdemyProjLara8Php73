<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date->diffForHumans() }}
    @isset($name)
        by {{ $name }}
    @endif
</p>
