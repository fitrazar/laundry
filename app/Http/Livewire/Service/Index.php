<?php

namespace App\Http\Livewire\Service;

use App\Exports\ServiceExport;
use App\Models\Service;
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
        'destroyService',
        'destroyAll',
    ];

    public $name, $service_id;
    public $search;
    public $page = 1;

    public function render()
    {
        return view('livewire.service.index', [
            'services' => Service::where('name', 'like', '%'.$this->search.'%')->latest()->paginate(10)
        ])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->name = '';
    }

    protected $rules = [
        'name' => 'required|string',
    ];

    protected $messages = [
        'name.required' => ':attribute Wajib Diisi.',
    ];
 
    protected $validationAttributes = [
        'name' => 'Nama Layanan',
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

    public function storeService()
    {
        $validatedData = $this->validate();

        Service::create($validatedData);

        $this->alert('success', 'Layanan berhasil ditambahkan', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 5000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editService($service_id)
    {
        $service = Service::findOrFail($service_id);
        $this->service_id = $service->id;
        $this->name = $service->name;
        $this->resetErrorBag();
    }

    public function updateService()
    {
        $validatedData = $this->validate();
        Service::where('id', $this->service_id)->update([
            'name' => $validatedData['name'],
        ]);
        $this->alert('success', 'Layanan Berhasil Diupdate.', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 4000,
        ]);
        $this->resetInput();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteService($service_id)
    {
        $service = Service::find($service_id);
        $this->service_id = $service_id;

        $this->alert('question', 'Yakin ingin menghapus '. $service->name .' ?', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'toast' => false,
            'timer' => 0,
            'confirmButtonText' => 'Yakin',
            'cancelButtonText' => 'Tidak',
            'onConfirmed' => 'destroyService' 
        ]);
    }

    public function destroyService()
    {
        Service::find($this->service_id)->delete();
        $this->alert('success', 'Layanan Berhasil Dihapus.', [
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
        $this->alert('question', 'Yakin ingin menghapus semua data layanan?', [
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
        Service::whereNotNull('id')->delete();
        $this->alert('success', 'Layanan Berhasil Dihapus.', [
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
		return Excel::download(new ServiceExport, 'Layanan.xlsx');
	}
}
