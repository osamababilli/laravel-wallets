<?php

namespace App\Livewire\Languages;


use Livewire\Component;
use App\Models\Language;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Flux\Flux;

class LanguageIndex extends Component
{
    use WithPagination;

    public $name, $code, $direction = 'ltr', $is_active = true, $is_default = false;

    public $search = '';
    public $perPage = 10;
    public $sortDirection = 'desc';


    public function edit($language)
    {
        // dd($Language);
        // dd('edit' . $Language);
        $this->dispatch('editLanguage', language: $language);
    }


    #[On('refresh')]
    public function refresh()
    {

        $this->render(); // Reset to the first page
    }

    public function delete(string $id)
    {

        confermeDelete(
            $this,
            __('Are you sure'),
            __('Are you sure you want to delete this language?'),
            $id
        );
    }

    #[On('delete-confirmted')]
    public function deleteConfirmted(string $id)
    {


        $item = Language::find($id);
        $item->delete();
        // $this->dispatch('deleted',  message: $item->name . '  ' . __('item Deleted Successfully'), type: 'success');

        notify($item->name . '  ' . __('language Deleted Successfully'), 'success', false);
    }


    public function saveLanguage()
    {

        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code',
            'direction' => 'required|in:ltr,rtl',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ]);

        Flux::modal('languageFormModal')->close();



        $language =  Language::create([
            'name' => $this->name,
            'code' => $this->code,
            'direction' => $this->direction,
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
        ]);

        if ($this->is_default) {

            Language::where('is_default', true)->where('id', '!=', $language->id)->update(['is_default' => false]);
            $language->update(['is_default' => true]);
        }

        notify(__('Language Created Successfully'), 'success', false);

        $this->reset(['name', 'code', 'direction', 'is_active', 'is_default']);

        // dd('create');
    }

    public function getData()
    {

        $query = Language::query();

        if ($this->search) {
            $this->resetPage();
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        return $query->where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->sortDirection)->paginate($this->perPage);
    }







    public function render()
    {

        $languages = $this->getData();
        return view('livewire.languages.language-index', compact('languages'));
    }
}
