@extends('layouts.admin')

@section('title')
    Ubah Produk
@endsection

@section('titleProp')
@endsection

@push('style')
    <style>
        #image-container {
            width: 100%;
            padding: 25px 0px;
            display: flex;
            align-items: center;
            margin: 10px auto;
            gap: 20px;
            justify-content: space-evenly;
            flex-wrap: wrap;
            border: 1px dashed black;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        figure {
            width: 45%;
        }
        .img-input {
            width: 100%;
        }
    </style>
@endpush

@push('script')
    <script>
        const imageContainer = document.getElementById('image-container');
        const fileInput = document.getElementById('file-input');

        const preview = () => {
            imageContainer.innerHTML = "";

            for(i of fileInput.files) {
                let reader = new FileReader();
                let figure = document.createElement("figure");
                let figcap = document.createElement("figcaption");
                figcap.innerText = i.name;
                figure.appendChild(figcap);
                reader.onload = () => {
                    let img = document.createElement("img");
                    img.setAttribute("class", "img-input")
                    img.setAttribute("src", reader.result);
                    figure.insertBefore(img, figcap);
                }
                imageContainer.appendChild(figure);
                reader.readAsDataURL(i);
            }
        }

        @if ($product->product_image)
            imageContainer.innerHTML = "";
            @foreach($product->product_image as $image)
                {
                    let figure = document.createElement("figure");
                    let img = document.createElement("img");
                    img.setAttribute("class", "img-input");
                    img.setAttribute("src", "{{ asset('images/products/' . $image->image) }}");
                    figure.appendChild(img);
                    imageContainer.appendChild(figure);
                }
            @endforeach
        @endif
    </script>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card rounded-lg w-100">
            <div class="card-body p-3">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!,</strong> cek kesalahan input berikut :
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $product->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="description" class="form-control" value="{{ $product->description }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price">Harga <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="product_category_id">Kategori <span class="text-danger">*</span></label>
                        <select name="product_category_id" id="product_category_id" class="form-control" required>
                            <option disabled>--- Pilih Kategori ---</option    tion>
                            @foreach ($productCategories as $item)
                                @if ($item->id == $product->product_category_id)
                                    <option value="{{ $item->id }}" selected>{{ $item->title }}</option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="images">Gambar <span class="text-danger">*</span></label>
                        <div id="image-container" onclick="document.getElementById('file-input').click();">
                            <h4 style="font-size: 25px;">Masukkan gambar (jpg, png, jpeg)</h4>
                        </div>
                        <input type="file" name="images[]" onchange="preview();" multiple id="file-input" style="display: none;" accept="image/png, image/jpg, image/jpeg">
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-dark" onclick="window.history.go(-1);">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
