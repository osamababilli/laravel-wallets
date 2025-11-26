<div>


    <flux:heading size="lg" class="text-zinc-900 dark:text-zinc-300 mb-4">{{ __('Create New Permission') }}
    </flux:heading>

    <div class="max-w-2xl">
        <form method="POST" wire:submit="createPermission" class="flex flex-col gap-6">
            <!-- Role Name -->
            <flux:input wire:model.blur="permissionName" :label="__('Permission Name')" type="text" required
                placeholder="{{ __('Permission Name') }}" />

            <flux:select wire:model="guardName" :label="__('Guard Name')" placeholder="{{ __('Select Guard Name') }}">


                @foreach (array_keys(config('auth.guards')) as $guard)
                    <flux:select.option>{{ $guard }}</flux:select.option>
                @endforeach

            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Create') }}</flux:button>
            </div>
        </form>

    </div>
</div>
