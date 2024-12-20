@extends('admin.admin_master')
@section('admin')


  <!-- Content Wrapper. Contains page content -->
  
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			   
		 

			<div class="col-8">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">SubCategory List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Category </th>
								<th>SubCategory En</th>
								<th>SubCategory Hin </th>
								<th>Action</th>
								 
							</tr>
						</thead>
						<tbody>
	 @foreach($subcategory as $item)
	 <tr>
		<td> {{ $item['category']['category_name_en'] }}  </td>
		<td>{{ $item->subcategory_name_en }}</td>
		 <td>{{ $item->subcategory_name_hin }}</td>
		<td>
 <a href="{{ route('subcategory.edit',$item->id) }}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i> </a>

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
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->

			          
			</div>
			<!-- /.col -->


<!--   ------------ Add Category Page -------- -->


          <div class="col-4">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Add SubCategory </h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">


 <form method="post" action="{{ route('subcategory.store') }}" >
	 	@csrf
					   

	 <div class="form-group">
	<h5>Category Select <span class="text-danger">*</span></h5>
	<div class="controls">
		<select name="category_id" class="form-control"  >
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
	 <input type="text" name="subcategory_name_en" class="form-control" >
     @error('subcategory_name_en') 
	 <span class="text-danger">{{ $message }}</span>
	 @enderror 
	  </div>
	</div>


	<div class="form-group">
		<h5>SubCategory Hindi  <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text" name="subcategory_name_hin" class="form-control" >
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
				<!-- /.box-body -->
			  </div>
			  <!-- /.box --> 
			</div>

 


		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
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
	$(document).ready(function() {
    // When category is selected
    $('#category-select').on('change', function() {
        let categoryId = $(this).val(); // Get selected category ID
        if (categoryId) {
            // AJAX call to fetch subcategories
            $.ajax({
                url: "{{ url('/subcategory/ajax') }}/" + categoryId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Clear and populate the subcategory dropdown
                    $('#subcategory-select').empty();
                    $('#subcategory-select').append('<option value="" disabled selected>Select SubCategory</option>');
                    $.each(data, function(index, subcategory) {
                        $('#subcategory-select').append('<option value="' + subcategory.id + '">' + subcategory.subcategory_name_en + '</option>');
                    });
                },
                error: function(xhr) {
                    console.error("Error fetching subcategories:", xhr);
                }
            });
        } else {
            // Reset subcategory dropdown if no category is selected
            $('#subcategory-select').empty();
            $('#subcategory-select').append('<option value="" disabled selected>Select SubCategory</option>');
        }
    });
});


	
</script>


@endsection