<div>


    <flux:heading size="lg" class="text-zinc-900 dark:text-zinc-300 mb-4">{{ __('Edit Permission') }}
    </flux:heading>

    <div class="max-w-2xl">
        <form method="POST" wire:submit="updatePermission" class="flex flex-col gap-6">
            <!-- Role Name -->
            <flux:input wire:model="PermissionName" :label="__('Permission Name')" type="text" required
                placeholder="{{ __('Permission Name') }}" />

            <flux:select disabled wire:model="guardName" :label="__('Guard Name')"
                placeholder="{{ __('Select Guard Name') }}">


                @foreach (array_keys(config('auth.guards')) as $guard)
                    <flux:select.option>{{ $guard }}</flux:select.option>
                @endforeach

            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Update') }}</flux:button>
            </div>
        </form>

    </div>
</div>
