<div class="modal fade" id="treatment-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="card">
                <div class="card-body pt-2">
                    <ul class="nav nav-tabs nav-tabs-bordered" style="align-items: center; grid-template-columns: repeat(2, 1fr);">

                        <li class="nav-item" style="padding-left: 30px; padding-right: 30px">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Detail Treatment</button>
                        </li>

                        <li class="nav-item" style="padding-left: 50px; padding-right: 50px">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Foto terkait</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <div >
                                <div class="col-lg-12 col-md-12 mb-2">
                                    <label >Nama Treatment</label>
                                    <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                        <p id="name"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mb-2">
                                    <label >Durasi</label>
                                    <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                        <p id="duration"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mb-2">
                                    <label >Harga</label>
                                    <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                        <p id="price"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mb-2">
                                    <label >Diskon</label>
                                    <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                        <p id="discount"></p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mb-2 row" >
                                    <label >Masa Berlaku</label>
                                    <div class="col-lg-5">
                                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                            <p id="period_start"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <p>Hingga</p>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card" style="padding-top: 5px; padding-left: 10px; padding-right: 10px">
                                            <p id="period_end"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-2" id="profile-edit">

                            <div class="col-lg-12" style="">
                                <div class="mb-4">
                                    <label class="image-preview" for="home_pict" style="background-image:none; aspect-ratio: 2/2;">
                                        <input type="file" name="home_pict" id="home_pict" class="d-none" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
