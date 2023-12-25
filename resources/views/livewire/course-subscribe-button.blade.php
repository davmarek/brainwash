<div>
    <x-primary-button wire:click="submit">
        {{ !$this->isSubscribed ? __('Subscribe') : __('Unsubscribe') }}
    </x-primary-button>
</div>
