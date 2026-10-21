<?php

use Livewire\Component;
use App\Models\Poll;
use App\Models\Option;
use Livewire\Attributes\On;

new class extends Component
{
    #[On('pollCreated')]
    public function with(): array
    {
        return [
            'polls' => Poll::with('options.votes')->latest()->get()
        ];
    }

    public function vote(Option $option)
    {
        $option->votes()->create();
    }
};
?>

<div>
    @forelse ($polls as $poll)
        <div class="mb-4">
            <h3 class="mb-4 text-xl">
                {{ $poll->title }}
            </h3>
            @foreach ($poll->options as $option)
                <div class="mb-2">
                    <button class="btn" wire:click="vote({{ $option->id }})">Vote</button>
                    {{ $option->name }} ({{ $option->votes->count() }})
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500">No polls available.</div>
    @endforelse
</div>
