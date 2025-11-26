<?php

namespace App\Livewire\Translations;

use App\Models\Translation;
use Livewire\Component;
use App\Services\TranslationService;
use Livewire\WithPagination;
use Flux\Flux;

class TranslationsManager extends Component
{

    use WithPagination;



    public $locale;


    public $search = '';
    public $perPage = 50;
    public $sortDirection = 'desc';


    public $id, $value, $translation;


    public function syncTranslation()
    {
        $service = app(TranslationService::class);
        $service->sync();

        $this->render();

        notify(__('Translations Synced Successfully'), 'success', false);
    }
    public function edit($id)
    {
        $this->translation = Translation::find($id);
        $this->id = $this->translation->id;
        $this->value = $this->translation->value;

        Flux::modal('edit-translation')->show();
    }

    public function update()
    {
        if ($this->translation) {
            $this->translation->value = $this->value;
            $this->translation->save();

            Flux::modal('edit-translation')->close();

            // إعادة تعيين الخصائص
            $this->reset(['translation', 'value', 'id']);

            notify(__('Translation Updated Successfully'), 'success', false);
        }
    }


    public function getTranslations()
    {


        $query = Translation::query();

        if ($this->search) {
            $this->resetPage();
            $query->where('key', 'like', '%' . $this->search . '%');
        }
        return $query->where('key', 'like', '%' . $this->search . '%')->where('locale', $this->locale)->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }
    public function render()
    {

        $translations = $this->getTranslations();
        return view('livewire.translations.translations-manager', compact('translations'));
    }
}
