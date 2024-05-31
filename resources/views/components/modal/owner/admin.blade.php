<div class="modal fade" id="admin-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="admin-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="admin-modal-title">--</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label mb-1">name</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label mb-1">Kota Cabang</label>
                        <select name="franchise_id" class="form-control @error('franchise_id') is-invalid @enderror"  aria-label="Small select example" id="franchise_id">
                            <option disabled selected>-- Pilih Cabang --</option>
                        </select>
                        <input type="hidden">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label mb-1">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label mb-1">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
