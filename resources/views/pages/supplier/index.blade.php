@extends('layouts.admin')

@section('title')
    Supplier
@endsection

@section('titleProp')
<button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary">Tambah</button>
@endsection

@push('style')
@endpush

@push('script')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.supplier.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'description', name: 'description'},
                {data: 'products', name: 'products'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

        });

        $('#myTable').on('click', '.edit', function(){
            var id = $(this).data('id');
            $.get("/admin/kategori-produk/edit/" + id, function(data){
                $('#editModal form').attr('action', `/admin/kategori-produk/update/${data.id}`);
                $('#editModal input#title').val(data.title);
                $('#editModal input#description').val(data.description);
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
            });
        });
        $('#myTable').on('click', '.delete-btn', function(){
            Swal.fire({
                title: "Yakin?",
                text: "Anda akan menghapus data kategori produk!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#0D6EFD",
                cancelButtonColor: "#d33",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
            });
        });
    });

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
                <table class="table table-striped table-hover my-0" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Produk</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{ route('admin.product_category.store') }}" method="post">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Tambah Supplier</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="phone">No HP <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="address">Alamat <span class="text-danger">*</span></label>
                        <textarea name="address" id="address" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="products">Produk</label>
                        <datalist id="keywordsList">
                            <option value="Kata Kunci 1">
                            <option value="Kata Kunci 2">
                            <option value="Kata Kunci 3">
                        </datalist>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </form>
  </div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post">
        @csrf
        @method('PUT')
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Ubah Kategori</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description">Deskripsi <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="description" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </form>
  </div>
@endsection
