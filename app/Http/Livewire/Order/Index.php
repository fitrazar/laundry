<?php

namespace App\Http\Livewire\Order;

use App\Exports\OrderExport;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Str;
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
        'destroyOrder',
        'destroyAll',
    ];

    public $customer_id, $service_id, $code, $pickup, $delivery, $price, $status, $order_id;
    public $search;
    public $page = 1;

    public function render()
    {
        return view('livewire.order.index', [
            'orders' => Order::where('code', 'like', '%'.$this->search.'%')->latest()->paginate(10),
            'customers' => Customer::all(),
            'services' => Service::all(),
        ])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->customer_id = '';
        $this->service_id = '';
        $this->code = '';
        $this->pickup = '';
        $this->delivery = '';
        $this->price = '';
        $this->status = '';
    }

    protected $rules = [
        'customer_id' => 'required|not_in:""',
        'service_id' => 'required|not_in:""',
        'pickup' => 'required',
        'delivery' => 'required',
        'price' => 'required|numeric',
        'status' => 'required',
    ];

    protected $messages = [
        'customer_id.required' => ':attribute Wajib Diisi.',
        'service_id.required' => ':attribute Wajib Diisi.',
        'pickup.required' => ':attribute Wajib Diisi.',
        'delivery.required' => ':attribute Wajib Diisi.',
        'price.required' => ':attribute Wajib Diisi.',
        'price.numeric' => ':attribute Harus Angka.',
        'status.required' => ':attribute Wajib Diisi.',
    ];
 
    protected $validationAttributes = [
        'customer_id' => 'Nama Pelanggan',
        'service_id' => 'Nama Layanan',
        'pickup' => 'Tanggal Pengambilan',
        'delivery' => 'Tanggal Pengiriman',
        'price' => 'Harga',
        'status' => 'Status',
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

    public function storeOrder()
    {
        $validatedData = $this->validate();

        $validatedData['code'] = 'rpl-'.Str::random(10);

        Order::create($validatedData);

        $this->alert('success', 'Order berhasil ditambahkan', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 5000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editOrder($order_id)
    {
        $order = Order::findOrFail($order_id);
        $this->order_id = $order->id;
        $this->status = $order->status;
        $this->customer_id = $order->customer_id;
        $this->service_id = $order->service_id;
        $this->code = $order->code;
        $this->pickup = $order->pickup;
        $this->delivery = $order->delivery;
        $this->price = $order->delivery;
        $this->resetErrorBag();
    }

    public function updateOrder()
    {
        $validatedData = $this->validate();
        Order::where('id', $this->order_id)->update([
            'status' => $validatedData['status'],
        ]);
        $this->alert('success', 'Status Berhasil Diupdate.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteOrder($order_id)
    {
        $order = Order::find($order_id);
        $this->order_id = $order_id;

        $this->alert('question', 'Yakin ingin menghapus '. $order->code .' ?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'toast' => false,
            'timer' => 0,
            'confirmButtonText' => 'Yakin',
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'destroyOrder' 
        ]);
    }

    public function destroyOrder()
    {
        Order::find($this->order_id)->delete();
        $this->alert('success', 'Order Berhasil Dihapus.', [
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
        $this->alert('question', 'Yakin ingin menghapus semua data Order?', [
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
        Order::whereNotNull('id')->delete();
        $this->alert('success', 'Order Berhasil Dihapus.', [
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
		return Excel::download(new OrderExport, 'Order.xlsx');
	}
}
