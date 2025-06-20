<div class="modal fade" id="packet-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="packet-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="packet-modal-title">Detail Paket Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 mb-2">
                        <label>Nama Paket</label>
                        <div class="card px-3 py-2">
                            <p id="name" class="mb-0"></p>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 mb-2">
                        <label>Treatments</label>
                        <div class="card px-3 py-2">
                            <p id="treatments" class="mb-0"></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="mb-1">Harga Normal</label>
                            <div class="card px-3 py-2">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="mb-0">Rp. </span>
                                    <p class="mb-0" id="packet_price"></p>
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
