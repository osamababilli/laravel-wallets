    <div x-data="{
        id: @entangle('id'),
        name: @entangle('name'),
        code: @entangle('code'),
        direction: @entangle('direction'),
        is_active: @entangle('is_active'),
        is_default: @entangle('is_default')
    }"
        x-on:open-language-edit.window="
        id = $event.detail.id;
        name = $event.detail.name;
        code = $event.detail.code;
        direction = $event.detail.direction;
        is_active = $event.detail.is_active;
        is_default = $event.detail.is_default;
        $flux.modal('languageEditModal').show();
    ">
        <flux:modal name="languageEditModal" class="w-full md:w-1/2" :dismissible="false">
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Edit Language') }}</flux:heading>

                <flux:input x-model="name" label="{{ __('Name') }}" placeholder="{{ __('Language Name') }}" />

                <flux:input x-model="code" label="{{ __('Code') }}"
                    placeholder="{{ __('Language Code (e.g., en, fr, ar)') }}" />

                <flux:select x-model="direction" label="{{ __('Direction') }}">
                    <option value="ltr">{{ __('Left to Right (LTR)') }}</option>
                    <option value="rtl">{{ __('Right to Left (RTL)') }}</option>
                </flux:select>

                <flux:checkbox x-model="is_active" label="{{ __('Active') }}" />
                @can('set default language')
                    <flux:checkbox x-model="is_default" label="{{ __('Default') }}" />
                @endcan

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" class="cursor-pointer" wire:loading.attr="disabled"
                        x-on:click="$wire.updateLanguage({
                        id,
                        name,
                        code,
                        direction,
                        is_active,
                        is_default
                    })"
                        variant="primary">
                        {{ __('Save') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
