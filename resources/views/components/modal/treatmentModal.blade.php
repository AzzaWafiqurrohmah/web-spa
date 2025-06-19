<div class="modal fade" id="treatment-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="tool-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="treatment-modal-title">Detail Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 mb-2">
                        <label >Nama Treatment</label>
                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                            <p id="name"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="mb-1">Durasi</label>
                            <div class="card px-3 py-2">
                                <div class="d-flex align-items-center gap-1">
                                    <p class="mb-0" id="duration"></p>
                                    <span class="mb-0">Menit</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="mb-1">Diskon</label>
                            <div class="card px-3 py-2">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="mb-0">Rp. </span>
                                    <p class="mb-0" id="discount"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="mb-1">Harga Normal</label>
                            <div class="card px-3 py-2">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="mb-0">Rp. </span>
                                    <p class="mb-0" id="price"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="mb-1">Harga Member</label>
                            <div class="card px-3 py-2">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="mb-0">Rp. </span>
                                    <p class="mb-0" id="member_price"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-12 col-md-12 mb-2">
                        <label >Mulai Berlaku</label>
                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                            <p id="period_start"></p>
                        </div>
                    </div>    --}}
                    <div class="col-lg-12 col-md-12 mb-2">
                        <label >Alat Treatment</label>
                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                            <p id="tools"></p>
                        </div>
                    </div>   
                    <div class="col-lg-12 col-md-12 mb-2">
                        <label >Bahan Treatment</label>
                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                            <p id="materials"></p>
                        </div>
                    </div>                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
