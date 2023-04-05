<div>
    @include('livewire.customer.modal')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pelanggan</h1>
        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="card shadow mb-4">

                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">List Pelanggan</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Action</div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create" role="button">Tambah</a>
                                <a class="dropdown-item" href="#" role="button" wire:click="export">Export</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" wire:click="deleteAll" role="button">Hapus Semua</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <input type="search" class="form-control mb-3" placeholder="Cari..." wire:model="search" >
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No Telepon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No Telepon</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ ($customers->currentpage()-1) * $customers->perpage() + $loop->index + 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-sm text-white" href="#" wire:click.prevent="editCustomer({{ $customer->id }})" data-bs-toggle="modal" data-bs-target="#edit"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <a class="btn btn-danger btn-sm" href="#" wire:click.prevent="deleteCustomer({{ $customer->id }})"><i class="fa-regular fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
