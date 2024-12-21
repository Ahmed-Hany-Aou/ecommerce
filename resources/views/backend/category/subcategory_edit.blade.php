@extends('admin.admin_master')
@section('admin')

<div class="container-full">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Edit SubCategory Page -->
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit SubCategory</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <!-- Start the form here -->
                            <form id="editSubCategoryForm" method="post" action="{{ route('subcategory.update') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $subcategory->id }}">

                                <!-- Category Select Dropdown -->
                                <div class="form-group">
                                    <h5>Category Select <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="category_id" class="form-control">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>
                                                    {{ $category->category_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- SubCategory English -->
                                <div class="form-group">
                                    <h5>SubCategory English <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="subcategory_name_en" class="form-control" value="{{ $subcategory->subcategory_name_en }}">
                                        @error('subcategory_name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- SubCategory Hindi -->
                                <div class="form-group">
                                    <h5>SubCategory Hindi <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <input type="text" name="subcategory_name_hin" class="form-control" value="{{ $subcategory->subcategory_name_hin }}">
                                        @error('subcategory_name_hin')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- SweetAlert for Notifications -->
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

<!-- JavaScript for AJAX Form Submission -->
<script>
    $(document).on('submit', '#editSubCategoryForm', function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let formAction = $(this).attr('action');
        let submitButton = $(this).find('input[type="submit"]');

        // Disable submit button to avoid duplicate submissions
        submitButton.prop('disabled', true);

        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response['alert-type'] === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('all.subcategory') }}"; // Redirect to subcategory list
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
            },
            complete: function () {
                submitButton.prop('disabled', false); // Re-enable the submit button
            }
        });
    });
</script>

@endsection
