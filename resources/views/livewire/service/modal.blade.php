<!-- Modal Create -->
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createLabel">Tambah Layanan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='storeService' wire:loading.attr="hidden" wire:submit="storeService"></button>
        </div>
        <form wire:submit.prevent="storeService">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="Nama Layanan" wire:model.defer="name">
                                <label for="floatingInput">Nama</label>
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='storeService' wire:loading.attr="hidden" wire:submit="storeService">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='storeService' wire:loading.attr="hidden">Simpan</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="storeService">
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
          <h1 class="modal-title fs-5" id="editLabel">Edit Layanan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='updateService' wire:loading.attr="hidden" wire:submit="updateService"></button>
        </div>
        <form wire:submit.prevent="updateService">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingInput" placeholder="Nama Layanan" value="{{ old('name', $name) }}" wire:model.defer="name">
                                <label for="floatingInput">Nama</label>
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='updateService' wire:loading.attr="hidden" wire:submit="updateService">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='updateService' wire:loading.attr="hidden">Update</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="updateService">
                  <span class="visually-hidden">Loading...</span>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>