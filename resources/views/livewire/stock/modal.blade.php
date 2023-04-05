<!-- Modal Create -->
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createLabel">Tambah Stok Barang</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='storeCustomer' wire:loading.attr="hidden" wire:submit="storeCustomer"></button>
        </div>
        <form wire:submit.prevent="storeStock">
            <div class="modal-body">
                <div class="container">
                    @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="Nama Pelanggan" wire:model.defer="name">
                                <label for="floatingInput">Nama</label>
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="floatingInput" placeholder="Jumlah" wire:model.defer="quantity">
                                <label for="floatingInput">Jumlah</label>
                            </div>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='storeStock' wire:loading.attr="hidden" wire:submit="storeStock">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='storeStock' wire:loading.attr="hidden">Simpan</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="storeStock">
                  <span class="visually-hidden">Loading...</span>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>

<!-- Modal Edit -->
<div class="modal fade" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editLabel">Edit Stok Barang</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='updateStock' wire:loading.attr="hidden" wire:submit="updateStock"></button>
        </div>
        <form wire:submit.prevent="updateStock">
            <div class="modal-body">
                <div class="container">
                    @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="Nama Pelanggan" value="{{ old('name', $name) }}" wire:model.defer="name">
                                <label for="floatingInput">Nama</label>
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="floatingInput" placeholder="Jumlah" value="{{ old('quantity', $quantity) }}" wire:model.defer="quantity">
                                <label for="floatingInput">Jumlah</label>
                            </div>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='updateStock' wire:loading.attr="hidden" wire:submit="updateStock">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='updateStock' wire:loading.attr="hidden">Update</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="updateStock">
                  <span class="visually-hidden">Loading...</span>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>