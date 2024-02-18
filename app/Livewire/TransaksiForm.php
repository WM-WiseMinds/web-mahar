<?php

namespace App\Livewire;

use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;

class TransaksiForm extends ModalComponent
{
    use Toastable;

    public Transaksi $transaksi;
    public $user, $id, $user_id, $total_harga, $status, $keranjangItems, $ukuranStandar, $ukuranCustom, $hargaStandar, $hargaCustom, $totalHargaItems, $grandTotal;
    public $keranjangIds = [];
    public $updatingStatusOnly = false;

    public function render()
    {
        $user = User::all();
        return view('livewire.transaksi-form', compact('user'));
    }

    public function switchToStatusOnlyMode()
    {
        $this->updatingStatusOnly = true;
    }

    public function switchToCreateOrUpdateMode()
    {
        $this->updatingStatusOnly = false;
    }

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'total_harga' => 'required',
        'status' => 'required',
    ];

    public function resetCreateForm()
    {
        $this->user_id = '';
        $this->total_harga = '';
        $this->status = '';
    }

    public function store()
    {
        if ($this->updatingStatusOnly) {
            $validated = $this->validate(['status' => 'required']);
            $this->transaksi->status = $validated['status'];
        } else {
            $validated = $this->validate();

            // Menyimpan data Transaksi
            $transaksi = Transaksi::create($validated);

            // Menyimpan data Detail Transaksi
            foreach ($this->keranjangItems as $keranjangItem) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'nama_barang' => $keranjangItem->barang->nama_barang,
                    'jumlah' => $keranjangItem->jumlah,
                    'ukuran' => $keranjangItem->ukuran,
                    'harga' => $keranjangItem->barang->harga,
                ]);
            }
        }
        $this->transaksi->save();

        $this->success($this->transaksi->wasRecentlyCreated ? 'Transaksi berhasil fibuat' : 'Transaksi berhasil diubah');

        $this->closeModalWithEvents([
            TransaksiTable::class => 'transaksiUpdated'
        ]);
    }

    public function mount($rowId = null, $updatingStatusOnly = false, $keranjangIds = null)
    {
        $this->keranjangIds = $keranjangIds;
        $this->updatingStatusOnly = $updatingStatusOnly;
        $this->user = User::all();
        if ($rowId) {
            $this->transaksi = Transaksi::find($rowId);

            if ($updatingStatusOnly) {
                $this->status = $this->transaksi->status;
            }
            $this->user_id = $this->transaksi->user_id;
            $this->total_harga = $this->transaksi->total_harga;
        }

        if ($keranjangIds) {
            $this->keranjangItems = Keranjang::whereIn('id', $keranjangIds)->get();
            $this->user_id = auth()->user()->id;
            $this->status = 'Belum Terbayar';
            // Inisialisasi properti
            foreach ($this->keranjangItems as $keranjangItem) {
                $this->ukuranStandar[$keranjangItem->id] = $keranjangItem->ukuran_id != null;
                $this->ukuranCustom[$keranjangItem->id] = $keranjangItem->ukuran_custom_id != null;
                $this->hargaStandar[$keranjangItem->id] = $keranjangItem->ukuran->harga;
                $this->hargaCustom[$keranjangItem->id] = $keranjangItem->ukuran_custom->harga;
                if ($keranjangItem->ukuran_custom_id) {
                    $this->totalHargaItems[$keranjangItem->id] = $keranjangItem->jumlah * $keranjangItem->ukuran_custom->harga;
                } else {
                    $this->totalHargaItems[$keranjangItem->id] = $keranjangItem->jumlah * $keranjangItem->ukuran->harga;
                }
            }

            $this->total_harga = array_sum($this->totalHargaItems);
        }
    }

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }
}
