<div class="p-6">
    <div class="mb-6">
        <flux:heading size="xl" level="1">{{ $event->title }}</flux:heading>
        <flux:subheading size="lg">{{ __('Event Details') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Event Date:</flux:text>
        <span>{{ $event->event_date }}</span>
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Description:</flux:text>
        <p>{{ $event->description }}</p>
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Article Content:</flux:text>
        {!! $event->article !!}
    </div>

    <div class="mb-4">
        <flux:text variant="strong">Tag:</flux:text>
        <span>{{ $event->tag }}</span>
    </div>

    @if($event->thumbnail)
        <div class="mb-4">
            <flux:text variant="strong">Thumbnail:</flux:text>
            <div>
                <img src="{{ asset('storage/' . $event->thumbnail) }}" 
                     class="w-32 h-32 object-cover rounded" alt="Event thumbnail">
            </div>
        </div>
    @endif

    <div>
        <flux:button href="{{ route('admin.events') }}" class="bg-gray-500 text-white p-2 rounded">
            {{ __('Back to Events') }}
        </flux:button>
    </div>
</div>
