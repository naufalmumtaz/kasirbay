@extends('layouts.admin')

@section('title')
    Produk
@endsection

@section('titleProp')
<a href="{{ route('admin.product.add') }}" class="btn btn-primary">Tambah</a>
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
            ajax: "{{ route('admin.product.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'image', name: 'image'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {data: 'price', name: 'price'},
                {data: 'product_category_id', name: 'product_category_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],

        });

        $('#myTable').on('click', '.delete-btn', function(){
            Swal.fire({
                title: "Yakin?",
                text: "Anda akan menghapus data produk!",
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
                <table class="table table-striped table-hover my-0" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Menu</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
