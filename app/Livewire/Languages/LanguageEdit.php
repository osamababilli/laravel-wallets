<?php

namespace App\Livewire\Languages;

use Livewire\Component;
use Flux\Flux;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use App\Models\Language;


class LanguageEdit extends Component
{
    public $id, $name, $code, $direction, $is_active, $is_default, $language;

    public function updateLanguage($data)
    {




        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->code = $data['code'];
        $this->direction = $data['direction'];
        $this->is_active = $data['is_active'];
        $this->is_default = $data['is_default'];

        $this->language = Language::findOrFail($this->id);


        // dd($this->language);
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('languages', 'code')->ignore($this->id),
            ],
            'direction' => 'required|in:ltr,rtl',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);


        if ($this->is_default) {
            $this->language->makeDefault();
            cache()->forget('default_language');
        }

        $this->language->update([
            'name' => $this->name,
            'code' => $this->code,
            'direction' => $this->direction,
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
        ]);


        notify(__('Language Updated Successfully'), 'success', false);


        Flux::modal('languageEditModal')->close();

        // إعادة تحميل الصفحة لتحديث البيانات
        $this->dispatch('refresh');
    }

    // #[On('editLanguage')]
    // public function edit($id)
    // {
    //     $language = Language::findOrFail($id); // أفضل استخدام findOrFail

    //     $this->language = $language;
    //     $this->id = $language->id; // لتسهيل الفاليديشن
    //     $this->name = $language->name;
    //     $this->code = $language->code;
    //     $this->direction = $language->direction;
    //     $this->is_active = $language->is_active;
    //     $this->is_default = $language->is_default;

    //     Flux::modal('languageEditModal')->show();
    // }


    // #[On('editLanguage')]
    public function edit($language)
    {
        // dd($language);
        // $this->fill($language);
        // Flux::modal('languageEditModal')->show();
    }


    public function render()
    {
        return view('livewire.languages.language-edit');
    }
}
