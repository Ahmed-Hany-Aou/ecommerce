@extends('admin.admin_master')
@section('admin')

<div class="container-full">
    <section class="content">
        <div class="row">
            <!-- SubCategory List -->
            <div class="col-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">SubCategory List</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>SubCategory En</th>
                                        <th>SubCategory Hin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategory as $item)
                                    <tr>
                                        <td>{{ $item['category']['category_name_en'] }}</td>
                                        <td>{{ $item->subcategory_name_en }}</td>
                                        <td>{{ $item->subcategory_name_hin }}</td>
                                        <td width="30%">
                                            <a href="{{ route('subcategory.edit', $item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-danger delete-subcategory" data-id="{{ $item->id }}" title="Delete Data">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add SubCategory Form -->
            <div class="col-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add SubCategory</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{ route('subcategory.store') }}">
                            @csrf
                            <div class="form-group">
                                <h5>Category Select <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <select name="category_id" id="category-select" class="form-control">
                                        <option value="" selected="" disabled="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name_en }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <h5>SubCategory English <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="subcategory_name_en" class="form-control">
                                    @error('subcategory_name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <h5>SubCategory Hindi <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="subcategory_name_hin" class="form-control">
                                    @error('subcategory_name_hin')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add New">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- AJAX Script for Dynamic Dropdown -->
<!-- SweetAlert Notification -->
@if(session('message'))
<script>
    Swal.fire({
        title: "{{ session('alert-type') == 'error' ? 'Error!' : 'Success!' }}",
        text: "{{ session('message') }}",
        icon: "{{ session('alert-type') }}",
        confirmButtonText: 'OK'
    });
</script>
@endif

<script>
    $(document).on('click', '.delete-subcategory', function (e) {
        e.preventDefault(); // Prevent default link behavior
        var id = $(this).data('id'); // Use the data-id attribute to fetch the ID

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('subcategory.delete', ':id') }}".replace(':id', id), // Route with dynamic ID
                    type: 'GET',
                    success: function (response) {
                        Swal.fire({
                            title: response['alert-type'] === 'error' ? 'Error!' : 'Deleted!',
                            text: response.message,
                            icon: response['alert-type'],
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (response['alert-type'] !== 'error') {
                                location.reload(); // Reload page only if the delete was successful
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>


@endsection
