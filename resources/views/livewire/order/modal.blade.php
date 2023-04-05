<!-- Modal Create -->
<div class="modal fade" id="create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createLabel">Tambah Order</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='storeOrder' wire:loading.attr="hidden" wire:submit="storeOrder"></button>
        </div>
        <form wire:submit.prevent="storeOrder">
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
                                <select class="form-control @error('customer_id') is-invalid @enderror" wire:model.defer='customer_id'>
                                    <option selected value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? ' selected' : ' ' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingInput">Pelanggan</label>
                            </div>
                            @error('customer_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select class="form-control @error('service_id') is-invalid @enderror" wire:model.defer='service_id'>
                                    <option selected value="">-- Pilih Layanan --</option>
                                    @foreach ($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? ' selected' : ' ' }}>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingInput">Layanan</label>
                            </div>
                            @error('service_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('pickup') is-invalid @enderror" id="floatingInput" placeholder="Pengambilan" wire:model.defer="pickup">
                                <label for="floatingInput">Tanggal Pengambilan</label>
                            </div>
                            @error('pickup')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('delivery') is-invalid @enderror" id="floatingInput" placeholder="Pengiriman" wire:model.defer="delivery">
                                <label for="floatingInput">Tanggal Pengiriman</label>
                            </div>
                            @error('delivery')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="floatingInput" placeholder="Harga" wire:model.defer="price">
                                <label for="floatingInput">Harga</label>
                            </div>
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select class="form-control @error('status') is-invalid @enderror" wire:model.defer='status'>
                                    <option selected value="">-- Pilih Status --</option>
                                    <option value="Dikirim" {{ old('status') == 'Dikirim' ? ' selected' : ' ' }}>Dikirim</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? ' selected' : ' ' }}>Pending</option>
                                    <option value="Batal" {{ old('status') == 'Batal' ? ' selected' : ' ' }}>Batal</option>
                                    <option value="Berhasil" {{ old('status') == 'Berhasil' ? ' selected' : ' ' }}>Berhasil</option>
                                </select>
                                <label for="floatingInput">Status</label>
                            </div>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='storeOrder' wire:loading.attr="hidden" wire:submit="storeOrder">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='storeOrder' wire:loading.attr="hidden">Simpan</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="storeOrder">
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
          <h1 class="modal-title fs-5" id="editLabel">Edit Status</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" wire:target='updateOrder' wire:loading.attr="hidden" wire:submit="updateOrder"></button>
        </div>
        <form wire:submit.prevent="updateOrder">
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
                                <select class="form-control @error('status') is-invalid @enderror" wire:model.defer='status'>
                                    <option selected value="">-- Pilih Status --</option>
                                    <option value="Dikirim" {{ old('status', $status) == 'Dikirim' ? ' selected' : ' ' }}>Dikirim</option>
                                    <option value="Pending" {{ old('status', $status) == 'Pending' ? ' selected' : ' ' }}>Pending</option>
                                    <option value="Batal" {{ old('status', $status) == 'Batal' ? ' selected' : ' ' }}>Batal</option>
                                    <option value="Berhasil" {{ old('status', $status) == 'Berhasil' ? ' selected' : ' ' }}>Berhasil</option>
                                </select>
                                <label for="floatingInput">Status</label>
                            </div>
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal" wire:target='updateOrder' wire:loading.attr="hidden" wire:submit="updateOrder">Tutup</button>
              <button type="submit" class="btn btn-primary" wire:target='updateOrder' wire:loading.attr="hidden">Update</button>
              <div class="mb-3" wire:loading.class="spinner-border text-primary d-block" wire:click="updateOrder">
                  <span class="visually-hidden">Loading...</span>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>