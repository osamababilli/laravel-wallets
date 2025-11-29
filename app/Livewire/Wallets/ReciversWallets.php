<?php

namespace App\Livewire\Wallets;

use App\Models\CryptoWalle;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;
use Livewire\Attributes\On;

class ReciversWallets extends Component
{
    use WithPagination;


    public $walletName, $walletAddress, $walletStatus;
    public $idToBeEdit;

    public function openEditModal($id)
    {


        // $this->idToBeEdit = $id;

        $wallet =  CryptoWalle::find($id);
        $this->idToBeEdit = $id;
        $this->walletName = $wallet->name;
        $this->walletAddress = $wallet->address;
        $this->walletStatus = $wallet->status;
        // dd($this->walletStatus);
        // dd($this->idToBeEdit);
        Flux::modal('edit-wallet-modal')->show();
    }

    public function EditWallet()
    {
        $wallet = CryptoWalle::find($this->idToBeEdit);
        $wallet->update([
            'name' => $this->walletName,
            'address' => $this->walletAddress,
            'status' => $this->walletStatus,
        ]);
        $this->walletName = '';
        $this->walletAddress = '';
        $this->walletStatus = '';
        Flux::modal('edit-wallet-modal')->close();
        notify('Wallet Updated Successfully', 'success', false);
    }
    public function delete(string $id)
    {
        // $this->authorize('delete', CryptoWalle::class);


        confermeDelete(
            $this,
            __('Are you sure'),
            __('Are you sure you want to delete this User?'),
            $id
        );
    }

    #[On('delete-confirmted')]
    public function deleteConfirmted(string $id)
    {


        $User = CryptoWalle::find($id);
        $User->delete();

        notify($User->name . '  ' . __('Role Deleted Successfully'), 'success', false);
    }






    public function createWallet()
    {
        CryptoWalle::create([
            'name' => $this->walletName,
            'address' => $this->walletAddress,
            'status' => $this->walletStatus,
        ]);
        $this->walletName = '';
        $this->walletAddress = '';
        $this->walletStatus = '';
        Flux::modal('Create-wallet-modal')->close();
        notify('Wallet Created Successfully', 'success', false);
    }
    public function render()
    {

        $wallets = CryptoWalle::paginate(20);
        return view('livewire.wallets.recivers-wallets', compact('wallets'));
    }
}
