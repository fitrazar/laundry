<?php

namespace App\Http\Livewire\Customer;

use App\Exports\CustomerExport;
use App\Models\Customer;
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
        'destroyCustomer',
        'destroyAll',
    ];

    public $name, $phone, $address, $customer_id;
    public $search;
    public $page = 1;

    public function render()
    {
        return view('livewire.customer.index', [
            'customers' => Customer::where('name', 'like', '%'.$this->search.'%')->latest()->paginate(10)
        ])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->phone = '';
        $this->address = '';
    }

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|numeric',
        'address' => 'required|max:500',
    ];

    protected $messages = [
        'name.required' => ':attribute Wajib Diisi.',
        'phone.required' => ':attribute Wajib Diisi.',
        'phone.numeric' => ':attribute Harus Angka.',
        'address.required' => ':attribute Wajib Diisi.',
    ];
 
    protected $validationAttributes = [
        'name' => 'Nama',
        'phone' => 'No Telepon',
        'address' => 'Alamat',
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

    public function storeCustomer()
    {
        $validatedData = $this->validate();

        Customer::create($validatedData);

        $this->alert('success', 'Pelanggan berhasil ditambahkan', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 5000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editCustomer($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $this->customer_id = $customer->id;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->resetErrorBag();
    }

    public function updateCustomer()
    {
        $validatedData = $this->validate();
        Customer::where('id', $this->customer_id)->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'] 
        ]);
        $this->alert('success', 'Pelanggan Berhasil Diupdate.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteCustomer($customer_id)
    {
        $customer = Customer::find($customer_id);
        $this->customer_id = $customer_id;

        $this->alert('question', 'Yakin ingin menghapus '. $customer->name .' ?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'toast' => false,
            'timer' => 0,
            'confirmButtonText' => 'Yakin',
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'destroyCustomer' 
        ]);
    }

    public function destroyCustomer()
    {
        Customer::find($this->customer_id)->delete();
        $this->alert('success', 'Pelanggan Berhasil Dihapus.', [
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
        $this->alert('question', 'Yakin ingin menghapus semua data pelanggan?', [
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
        Customer::whereNotNull('id')->delete();
        $this->alert('success', 'Pelanggan Berhasil Dihapus.', [
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
		return Excel::download(new CustomerExport, 'Pelanggan.xlsx');
	}
}
