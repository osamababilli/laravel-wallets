<div>
    <div>
        <flux:heading size="lg" class="text-zinc-900 dark:text-zinc-300 mb-4">{{ __('Update User') }}
        </flux:heading>
    </div>
    <form wire:submit.prevent="updateUser" class="space-y-6">

        <div class="grid grid-cols-3 gap-6 ">


            <flux:input wire:model.blur="name" :label="__('Name')" type="text" placeholder="{{ __('Name') }}" />

            <flux:input wire:model.blur="email" :label="__('Email')" type="email" placeholder="{{ __('Email') }}" />

            <flux:input wire:model.blur="phone" :label="__('Phone')" type="text"
                placeholder="{{ __('Phone') }}" />

            <flux:selectmultiple2 wire:model.live="selectedRoles" :options="$roles"
                :placeholder="__('Select User Roles')" :option-label="'name'" :option-value="'name'"
                label="{{ __('User Roles') }}" />


            <flux:input type="password" autocomplete="new-password" label="{{ __('Password') }}"
                wire:model.blur="password" viewable />

            <flux:input type="password" label="{{ __('Password Confirmation') }}"
                wire:model.blur="password_confirmation" viewable />

            <flux:select wire:model="UserStatus" placeholder="Choose industry...">
                <flux:select.option value="active">{{ __('Active') }}</flux:select.option>
                <flux:select.option value="inactive">{{ __('Inactive') }}</flux:select.option>

            </flux:select>


            <flux:button type="submit" class="hover:pointer">
                {{ __('Update User') }}
            </flux:button>

        </div>
    </form>

</div>
