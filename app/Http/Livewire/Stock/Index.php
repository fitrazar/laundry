<?php

namespace App\Http\Livewire\Stock;

use App\Exports\StockExport;
use App\Models\Stock;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'page' => ['except' => 1, 'as' => 'p'],
    ];
    protected $listeners = [
        'destroyStock',
        'destroyAll',
    ];

    public $name, $quantity, $stock_id;
    public $search;
    public $page = 1;

    public function render()
    {
        return view('livewire.stock.index', [
            'stocks' => Stock::where('name', 'like', '%'.$this->search.'%')->latest()->paginate(10)
        ])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->quantity = '';
    }

    protected $rules = [
        'name' => 'required|string',
        'quantity' => 'required|numeric',
    ];

    protected $messages = [
        'name.required' => ':attribute Wajib Diisi.',
        'quantity.required' => ':attribute Wajib Diisi.',
        'quantity.numeric' => ':attribute Harus Angka.',
    ];
 
    protected $validationAttributes = [
        'name' => 'Nama',
        'quantity' => 'Jumlah',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->resetErrorBag();
    }

    public function storeStock()
    {
        $validatedData = $this->validate();

        Stock::create($validatedData);

        $this->alert('success', 'Stok Barang berhasil ditambahkan', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 5000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editStock($stock_id)
    {
        $stock = Stock::findOrFail($stock_id);
        $this->stock_id = $stock->id;
        $this->name = $stock->name;
        $this->quantity = $stock->quantity;
        $this->resetErrorBag();
    }

    public function updateStock()
    {
        $validatedData = $this->validate();
        Stock::where('id', $this->stock_id)->update([
            'name' => $validatedData['name'],
            'quantity' => $validatedData['quantity'],
        ]);
        $this->alert('success', 'Stok Barang Berhasil Diupdate.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteStock($stock_id)
    {
        $stock = Stock::find($stock_id);
        $this->stock_id = $stock_id;

        $this->alert('question', 'Yakin ingin menghapus '. $stock->name .' ?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'toast' => false,
            'timer' => 0,
            'confirmButtonText' => 'Yakin',
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'destroyStock' 
        ]);
    }

    public function destroyStock()
    {
        Stock::find($this->stock_id)->delete();
        $this->alert('success', 'Stok Barang Berhasil Dihapus.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteAll()
    {
        $this->alert('question', 'Yakin ingin menghapus semua data stok barang?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'toast' => false,
            'timer' => 0,
            'confirmButtonText' => 'Yakin',
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'destroyAll' 
        ]);
    }

    public function destroyAll()
    {
        Stock::whereNotNull('id')->delete();
        $this->alert('success', 'Stok Barang Berhasil Dihapus.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function export()
	{
		return Excel::download(new StockExport, 'Stok Barang.xlsx');
	}
}
