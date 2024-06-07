@php
    $treatment = $treatment ?? null;
    $idTools = $treatment?->tools->pluck('id')->toArray() ?? [];
    $idMaterials = $treatment?->materials->pluck('id')->toArray() ?? [];
    $pictures = $treatment->pictures ?? ['none'];
@endphp
@csrf

<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Detail Treatment</h5>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="category_id">Kategori</label>
                    <select name="treatment_category_id" class="form-control @error('treatment_category_id') is-invalid @enderror"  aria-label="Small select example" id="treatmentCategory_id" autofocus>
                        <option disabled selected>-- Pilih Kategori --</option>
                        @foreach($treatmentCategories as $category)
                            <option value="{{$category->id}}" @selected($category->id == $treatment?->treatmentCategory->id|| old('treatment_category_id') == $category->id) >{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('treatment_category_id')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="fullname">Nama Treatment</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{old('name', $treatment?->name)}}">
                    @error('name')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <label for="duration">Durasi </label>
                <div class="mb-3">
                    <div class="input-group mb-1">
                        <input type="number" name="duration" id="duration" aria-describedby="basic-addon1" class="form-control @error('duration') is-invalid @enderror"value="{{old('duration', $treatment?->duration)}}">
                        <span class="input-group-text"> Menit </span>
                    </div>
                    @error("duration")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <label for="price"> Harga </label>
                <div class="mb-3">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> Rp </span>
                        <input type="number" name="price" id="price" aria-describedby="basic-addon1" class="form-control @error('price') is-invalid @enderror" value="{{old('price', $treatment?->price)}}">
                    </div>
                    @error("price")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>

                <label for="discount"> Diskon </label>
                <div class="mb-3">
                    <div class="input-group mb-1">
                        <span class="input-group-text"> Rp </span>
                        <input type="number" name="discount" id="discount" aria-describedby="basic-addon1" class="form-control @error('discount') is-invalid @enderror" value="{{old('discount', $treatment?->discount)}}">
                    </div>
                    @error("discount")
                    <small class="text-danger mb-3">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="period_start">Mulai Berlaku</label>
                    <div class="input-group">
                        <input id="period_start" type="date"  class="form-control @error('period_start') is-invalid @enderror" name="period_start" value="{{old('period_start', $treatment?->period_start)}}">
                    </div>
                    @error('period_start')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Alat dan Bahan</h5>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="tools">Alat Treatment</label>
                    <select style="padding-left: 12px" class="tags selected-options-new form-control" id="tools" name="tools[]" multiple>
                        @foreach($tools as $tool)
                            <option value="{{ $tool->id }}" @selected(in_array($tool->id, $idTools) || in_array($tool->id, old('tools', [])))>{{ $tool->name }}</option>
                        @endforeach
                    </select>
                    @error('tools')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="materials">Bahan Treatment</label>
                    <select class="tags selected-options-new form-control" id="materials" name="materials[]" multiple>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" @selected(in_array($material->id, $idMaterials) || in_array($material->id, old('materials', [])))>{{ $material->name }}</option>
                        @endforeach
                    </select>
                    @error('materials')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-2" style="font-weight: 500; margin-left: -10px; margin-top: -8px; color: #A2A2A2">Foto terkait</h5>
        <div class="row" id="picture-container">
            @foreach($pictures as $key => $pict)
                <div class="col-lg-4"  id="container">
                    <label class="image-preview" id="label" style=" background-image: url('{{ Storage::url( $pict ) }}');position: relative; aspect-ratio: 11/8;">
                        <input type="file" name="pictures[{{ $key }}]" id="pictures" class="d-none" accept="image/*">
                        <small class="{{ $treatment? 'd-none' : '' }}">
                            <i id="iconImage" style="font-size: 40px" class="bi bi-image-fill"></i>
                            <span>Klik untuk {{ $treatment ? 'mengganti' : 'mengunggah' }}</span>
                        </small>
                        <input type="hidden" name="deletePict[ {{ $key }} ]" value="{{ $key }}" disabled>
                        <span class="position-absolute top-0 end-0 me-2 {{ $treatment? '' : 'd-none' }}" id="delete" name="delete" style="font-size: 1.4rem; cursor: pointer">
                          <i class="bx bx-x"></i>
                        </span>
                    </label>
                    @error('pictures')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            @endforeach
                <div class="col-lg-4" id="addLabel">
                    <label class="image-preview" id="addPict" for="addIcon" style="background-image: none; aspect-ratio: 11/8;">
                        <small>
                            <i id="addIcon" style="font-size: 50px" class="bi bi-plus-circle-dotted"></i>
                        </small>
                    </label>
                </div>
            <div class="mb-2 text-end">
                <button type="submit" id="save" class="btn btn-primary">Simpan</button>
            </div>
        </div>

    </div>
</div>

@push('script')
    <script>
        $(document).ready(function (){
            $('.tags').select2({
                placeholder: ' -- Pilih Alat --',
                allowClear:true
            })


        })

        $(document).ready(function (){
            $('.tags2').select2({
                placeholder: ' -- Pilih Bahan --',
                allowClear:true
            })
        })

        function getSecond() {
            let now = new Date();
            let second = now.getSeconds();

            if (second < 10) {
                second = "0" + second;
            }
            return second;
        }

        function createGambar(code)
        {
            return `<div class="col-lg-4 mb-3" id="container">
                <label class="image-preview" for="pictures${code}" style="background-image: none; position: relative; aspect-ratio: 11/8;">
                    <input type="file" name="pictures[${code}]" id="pictures${code}" class="d-none" accept="image/*">
                    <small>
                        <i class="bi bi-image-fill" id="iconImage" style="font-size: 40px;"></i>
                        <span>klik untuk {{ $treatment ? 'mengganti' : 'mengunggah' }}</span>
                    </small>
                    <span class="position-absolute top-0 end-0 me-2" id="delete" name="delete" style="font-size: 1.4rem; cursor: pointer">
                          <i class="bx bx-x"></i>
                    </span>
                    <input type="hidden" disabled>
                </label>
            </div>`;
        }

        //for add label picture
        $('#addPict').on("click", function(){
            $(createGambar(getSecond())).insertBefore($('#addLabel'));
        })

        // for picture on change
        document.addEventListener('change', function(event) {
            const target = event.target;
            if (target && target.matches('input[type="file"]')) {
                const preview = target.parentElement;
                const file = target.files[0];
                const reader = new FileReader();
                $(target).next().addClass('d-none');

                reader.onload = function(e) {
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                }

                reader.readAsDataURL(file);
            }
        });

        //for delete picture
        $('#picture-container').on('click', '#delete', function(event) {
            const target = event.target;
            const container = target.closest('#container');
            const deleteInput = container.querySelector('input[type="hidden"]');

            deleteInput.removeAttribute('disabled');
            container.disabled = true;

            const  inputFile = target.closest('#container');
            inputFile.querySelector('input[type="file"]').remove();
            $(target).closest('#container').addClass('d-none');

        });

    </script>
@endpush
