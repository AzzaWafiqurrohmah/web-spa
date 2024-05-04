@php
    $treatment = $treatment ?? null;
    $idTools = $treatment?->tools->pluck('id')->toArray() ?? [];
    $idMaterials = $treatment?->materials->pluck('id')->toArray() ?? [];
@endphp
@csrf

<div class="card mb-3">
    <div class="card-body">
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Detail Treatment</h4>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="category_id">Kategori</label>
                    <select name="treatment_category_id" class="form-control @error('treatmentCategory_id') is-invalid @enderror"  aria-label="Small select example" id="treatmentCategory_id">
                        <option disabled selected>-- Pilih --</option>
                        @foreach($treatmentCategories as $category)
                            <option value="{{$category->id}}" @selected($category->id == $treatment?->treatmentCategory->id|| old('treatmentCategory_id') == $category->id) >{{$category->name}}</option>
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
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{old('name', $treatment?->name)}}" autofocus>
                    @error('name')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="duration">Durasi</label>
                    <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"  value="{{old('duration', $treatment?->duration)}}" autofocus>
                    @error('duration')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-4">
                    <label for="price">Harga</label>
                    <input type="number" name="price" value="{{old('price', $treatment?->price)}}" class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="discount">Diskon</label>
                    <input type="number" name="discount" value="{{old('discount', $treatment?->discount)}}" class="form-control @error('discount') is-invalid @enderror">
                    @error('discount')
                    <div class="invaid-feedback">
                        <small class="text-danger">{{ $message }}</small>
                    </div>
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
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Alat dan Bahan</h4>
        <div class="row">
            <div class="col-lg-5" style="margin-right: 30px;">
                <div class="mb-4">
                    <label for="tools">Alat Treatment</label>
                    <select class="tags selected-options-new form-control" id="tools" name="tools[]" multiple>
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
                            <option value="{{ $material->id }}" @selected(in_array($tool->id, $idMaterials) || in_array($material->id, old('materials', [])))>{{ $material->name }}</option>
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
        <h4 style="margin-bottom: 20px; margin-left: -5px; font-family: 'Times New Roman', Times, serif; font-weight: bold">Foto terkait</h4>
        <div class="row" id="picture-container">
                <div class="col-lg-4" >
                    <label class="image-preview" id="label" style="position: relative; aspect-ratio: 11/8;">
                        <input type="file" name="pictures[00]" id="pictures00" class="d-none" accept="image/*">
                        <small>
                            <i id="iconImage" style="font-size: 40px" class="bi bi-image-fill"></i>
                            <span>Klik untuk {{ $treatment ? 'mengganti' : 'mengunggah' }}</span>
                        </small>
                    </label>
                    @error('pictures')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-lg-4" id="addLabel">
                    <label class="image-preview" id="addPict" for="addIcon" style="background-image: none; aspect-ratio: 11/8;">
                        <small>
                            <i id="addIcon" style="font-size: 50px" class="bi bi-plus-circle-dotted"></i>
                        </small>
                    </label>
                </div>
            <div class="mb-2 text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
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



        $('#addPict').on("click", function(event){
            if (event.target && event.target.id === 'addPict' || event.target && event.target.id === 'addIcon') {
                const pictureContainer = document.getElementById('picture-container');
                const newContainer = createElement(getSecond());

                pictureContainer.insertBefore(newContainer.cloneNode(true), document.getElementById('addLabel'));
            }
        })

        const pictures = [];
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


        $('#picture-container').on('click', '#delete', function(e) {
            $(this).closest('#container').remove();
        });

        function createElement(code)
        {
            const container = document.createElement("div");
            container.classList.add("col-lg-4");
            container.id = "container";

            const label = document.createElement("label");
            label.classList.add("image-preview");
            label.setAttribute("for", "pictures" + code);
            label.style.backgroundImage = "none";
            label.style.position = "relative";
            label.style.aspectRatio = '11/8';

            const button = document.createElement('button');
            button.type = "button";
            button.classList.add("btn");
            button.classList.add("btn-outline-danger");
            button.id = "delete";

            const trash = document.createElement("i");
            trash.style.fontSize = '15px';
            trash.classList.add("bi");
            trash.classList.add("bi-trash3");

            button.appendChild(trash);

            const small = document.createElement("small");

            const icon = document.createElement("i");
            icon.style.fontSize = '40px';
            icon.classList.add("bi");
            icon.classList.add("bi-image-fill");
            icon.id = "iconImage";

            const span = document.createElement("span");
            span.innerText = "klik untuk {{ $treatment ? 'mengganti' : 'mengunggah' }}";

            small.appendChild(icon);
            small.appendChild(span);


            const inputFile = document.createElement("input");
            inputFile.type = "file";
            inputFile.name = "pictures[" + code + "]";
            inputFile.id = "pictures" + code;
            inputFile.classList.add("d-none");
            inputFile.accept = "image/*";

            label.appendChild(inputFile);
            label.appendChild(small);
            label.appendChild(button);
            container.appendChild(label);

            return container;
        }

        function getSecond() {
            let now = new Date();
            let second = now.getSeconds();

            if (second < 10) {
                second = "0" + second;
            }
            return second;
        }



    </script>
@endpush
