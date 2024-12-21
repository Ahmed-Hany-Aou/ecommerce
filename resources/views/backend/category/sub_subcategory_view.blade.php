@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-full">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Sub-SubCategory List -->
            <div class="col-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sub->SubCategory List</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>SubCategory Name</th>
                                        <th>Sub-Subcategory English</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subsubcategory as $item)
                                    <tr>
                                        <!-- Display the category name -->
                                        <td>{{ $item['category']['category_name_en'] ?? 'N/A' }}</td>

                                        <!-- Display the subcategory name -->
                                        <td>{{ $item['subcategory']['subcategory_name_en'] ?? 'N/A' }}</td>

                                        <!-- Display the sub-subcategory English name -->
                                        <td>{{ $item->subsubcategory_name_en }}</td>

                                        <!-- Action buttons -->
                                        <td width="30%">
                                            <a href="{{ route('subsubcategory.edit', $item->id) }}" class="btn btn-info" title="Edit Data">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger delete-subsubcategory" data-id="{{ $item->id }}" title="Delete Data">
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

            <!-- Add Sub-SubCategory -->
            <div class="col-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Sub-SubCategory</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <form method="post" action="{{ route('subsubcategory.store') }}">
                                @csrf
                                <div class="form-group">
                                    <h5>Category Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="category_id" class="form-control">
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
                                    <h5>SubCategory Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="subcategory_id" class="form-control">
                                            <option value="" selected="" disabled="">Select SubCategory</option>
                                        </select>
                                        @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Sub-SubCategory English <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="subsubcategory_name_en" class="form-control">
                                        @error('subsubcategory_name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Sub-SubCategory Hindi <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="subsubcategory_name_hin" class="form-control">
                                        @error('subsubcategory_name_hin')
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

<script>
    $(document).ready(function() {
        // Populate SubCategory dropdown based on selected Category
        $('select[name="category_id"]').on('change', function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ url('/category/subcategory/ajax') }}/" + category_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="subcategory_id"]').empty().append('<option value="" selected disabled>Select SubCategory</option>');
                        $.each(data, function(key, value) {
                            $('select[name="subcategory_id"]').append('<option value="' + value.id + '">' + value.subcategory_name_en + '</option>');
                        });
                    },
                });
            } else {
                $('select[name="subcategory_id"]').empty().append('<option value="" selected disabled>Select SubCategory</option>');
            }
        });

        // Handle Sub-SubCategory deletion
        $(document).on('click', '.delete-subsubcategory', function() {
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
                        url: "{{ route('subsubcategory.delete', ':id') }}".replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            if (response['alert-type'] === 'success') {
                                Swal.fire('Deleted!', response.message, 'success').then(() => {
                                    location.reload();
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
    });
</script>
@endsection
