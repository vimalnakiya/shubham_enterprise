@extends('layouts.layout')
@section('content')
<style>
   
</style>
<section class="section">
    <div class="text-end">
        <button type="button" id="click-btn" class="btn btn-primary">Add Product</button>
    </div>
    <div class="form-slide">
        <div class="d-flex justify-content-between mt-5">
            <h2>Product Form</h2>
            <button class="close-btn"><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg></span></button>
        </div>
        <div class="row edit_form"> 
            <form class="row g-3" name="add_form" method="POST" id="add_form" novalidate action="{{route('products.add')}}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select type" name="brand_id" aria-label="State">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <label for="type">Select Brand</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select type" name="category_id" aria-label="State">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="type">Select Category</label>
                    </div>
                </div>
               
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control name" name="name" placeholder="">
                        <label for="name">Product Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control name" name="price" placeholder="">
                        <label for="name">Product Price</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control name" name="maxqty" placeholder="">
                        <label for="name">Product Maximum Quantity</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control name" name="minqty" placeholder="">
                        <label for="name">Product Minimum Quantity</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="video_image">Image</label>
                    <input class="form-control video_image upload" id="upload" type="file" name="image">
                </div>
               
                <div class="image_preview" style="display:flex"></div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary save-btn">Save</button>
                    <button type="reset" class="btn btn-secondary reset-btn">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->
        </div>
    </div>
    <div class="card p-4 mt-5"> 
        {{ $dataTable->table() }}
    </div>         
</section>
<div class="modal fade" id="addStock" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Stock</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-circle"></i>
          </button>
        </div>
        <div class="modal-body">
          <p class="pt-3 product_name"></p>
          <label>Current Quantity</label>
          <input type="text" class="form-control current_quantity" readonly>
          
          <label>Add New Quantity</label>
          <input type="number" class="form-control new_quantity" value="0">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn modal-primary-btn btn-primary save-btn" data-bs-dismiss="modal">Cancel</button>
          <a href="#" class="btn modal-secondary-btn btn-danger save-btn save_stock" data-id="0">Save</a>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-circle"></i>
          </button>
        </div>
        <div class="modal-body">
          <p class="pt-3">Are you sure you want to delete this Product ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn modal-primary-btn btn-primary save-btn" data-bs-dismiss="modal">Cancel</button>
          <a href="#" class="btn modal-secondary-btn deleteUrl btn-danger save-btn">Delete</a>
        </div>
      </div>
    </div>
</div>
@endsection
@push('script')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script type="text/javascript">
$(document).ready(function() {
    $('#add_form').validate({
        rules: {
            'brand_id': {
                required: true
            },
            'category_id': {
                required: true
            },
            'name': {
                required: true
            },
            'price': {
                required: true
            },
            'image': {
                required: true
            },
            'maxqty': {
                required: true
            },
            'minqty': {
                required: true
            },

             
        },
        messages: {
            'brand_id': {
                required: "Please Select Brand"
            },
            'category_id': {
                required: "Please Select Category"
            },
            'name': {
                required: "Please Enter Product Name"
            },
            'image': {
                required: "Please Select Image"
            },
            'price': {
                required: "Please Enter Price"
            },
            'maxqty': {
                required: "Please Enter Maximum Quantity"
            },
            'minqty': {
                required: "Please Enter Minimum Quantity"
            },
            
        }
    });
});
$(document).on('click','.deleteBook',function(e){
    var id = $(this).data('id');
    $('.deleteUrl').attr('href','{{route("products.delete", ["id" => ""]) }}'+id);
});
$(document).on('click','.addStock',function(e){
    var id = $(this).data('id');
    $.ajax({
        type : 'POST',
        url  : "{{(route('products.get_stock'))}}",
        data : { 
            id : id ,
            _token: '{{ csrf_token() }}',
        },
        success: function(data){
            $('.product_name').text('Add Stock in '+data.name);
            $('.current_quantity').val(data.quantity);
            $('.save_stock').attr('data-id',id);
        }
    });
});
$(document).on('click','.save_stock',function(e){
    var id = $(this).data('id');
    var current_quantity = $('.current_quantity').val();
    var new_quantity = $('.new_quantity').val();
    $.ajax({
        type : 'POST',
        url  : "{{(route('products.save_stock'))}}",
        data : { 
            id : id ,
            _token: '{{ csrf_token() }}',
            new_quantity: new_quantity,
            current_quantity: current_quantity
        },
        success: function(data){
            window.location.reload();
        }
    });
})

$(document).on('click','.edit',function(e){
    var id = $(this).data('id');
    $.ajax({
        type : 'POST',
        url  : "{{(route('products.edit'))}}",
        data : { id : id ,_token: '{{ csrf_token() }}',},
        success: function(data){
            $('#add_form').hide();
            $('.edit_form').append(data);
            $('section').toggleClass('newClass');
            $('#update_form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                },
                messages: {
                    'name': {
                        required: "Please Enter Product"
                    },
                    'price': {
                        required: "Please Enter Price"
                    },
                   
                }
            });
        }
    });
})

</script>
@endpush