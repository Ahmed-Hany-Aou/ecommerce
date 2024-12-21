@extends('admin.admin_master')
@section('admin')

<div class="container-full">
    <section class="content">
        <div class="row">
            <!-- Category List -->
            <div class="col-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Category List</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category Icon</th>
                                        <th>Category En</th>
                                        <th>Category Hin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $item)
                                    <tr>
                                        <td><span><i class="{{ $item->category_icon }}"></i></span></td>
                                        <td>{{ $item->category_name_en }}</td>
                                        <td>{{ $item->category_name_hin }}</td>
                                        <td>
                                            <a href="{{ route('category.edit', $item->id) }}" class="btn btn-info" title="Edit Data">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger delete-category" data-id="{{ $item->id }}" title="Delete Data">
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

            <!-- Add Category Form -->
            <div class="col-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Category</h3>
                    </div>
                    <div class="box-body">
                        <form method="post" action="{{ route('category.store') }}">
                            @csrf
                            <div class="form-group">
                                <h5>Category English <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="category_name_en" class="form-control">
                                    @error('category_name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <h5>Category Hindi <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="category_name_hin" class="form-control">
                                    @error('category_name_hin')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <h5>Category Icon <span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input type="text" name="category_icon" class="form-control">
                                    @error('category_icon')
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

<!-- SweetAlert Delete Confirmation -->
<script>
    $(document).on('click', '.delete-category', function(e) {
        e.preventDefault(); // Prevent default behavior for the click event
        var id = $(this).data('id');
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
                    url: "{{ route('category.delete', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        if (response['alert-type'] === 'success') {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload(); // Reload the page to update the list
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                    }
                });
            }
        });
    });
</script>

@endsection
