<?php

use Livewire\Volt\Component;

new class extends Component {
    public $languages, $language, $default, $languageCode;

    public function mount()
    {
        $this->languages = App\Models\Language::where('is_active', 1)->get();
        $this->default = App\Models\Language::where('is_default', 1)->first();
        $this->languageCode = session()->get('locale') ?? $this->default->code;
    }

    public function setLanguage()
    {
        // dd($this->languageCode);
        // حفظ اللغة في الجلسة
        session(['locale' => $this->languageCode]);
        // dd(session('locale'));
        // تطبيق اللغة فورًا
        app()->setLocale($this->languageCode);

        // إعادة تحميل الصفحة لتطبيق التغييرات
        return redirect()->route('settings.languages');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Languages')" :subheading="__('Update the appearance settings for your account')">



        <form wire:submit.prevent="setLanguage">

            <flux:radio.group wire:model.live="languageCode">
                @foreach ($languages as $language)
                    <flux:radio value="{{ $language->code }}" label="{{ $language->name }}"
                        :checked="$language->code == $languageCode" />
                @endforeach
            </flux:radio.group>

            <flux:button type="submit" class="cursor-pointer mt-4" size="sm" variant="primary">
                {{ __('Save') }}
            </flux:button>
        </form>
    </x-settings.layout>
</section>
