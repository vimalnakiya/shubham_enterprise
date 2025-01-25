@extends('layouts.layout')
@section('content')
<style>
   
</style>
<section class="section">
    {{-- <div class="text-end">
        <button type="button" id="click-btn" class="btn btn-primary">Add Product</button>
    </div> --}}
    <div class="form-slide">
        <div class="d-flex justify-content-between mt-5">
            <h2>Product Form</h2>
            <button class="close-btn"><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg></span></button>
        </div>
        <div class="row edit_form"> 
           
        </div>
    </div>
    <div class="card p-4 mt-5"> 
        {{ $dataTable->table() }}
    </div>         
</section>
<div class="modal fade" id="deleteModal" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Verify User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-circle"></i>
          </button>
        </div>
        <div class="modal-body">
          <p class="pt-3">Are you sure you want to verify this User ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn modal-primary-btn btn-primary save-btn" data-bs-dismiss="modal">Cancel</button>
          <a href="#" class="btn modal-secondary-btn deleteUrl btn-danger save-btn">Verify</a>
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
            'name': {
                required: true
            },
            'price': {
                required: true
            },
            'image': {
                required: true
            },
             
        },
        messages: {
            'name': {
                required: "Please Enter Brand Name"
            },
            'image': {
                required: "Please Select Image"
            },
            'price': {
                required: "Please Enter Price"
            },
            
        }
    });
});
$(document).on('click','.deleteBook',function(e){
    var id = $(this).data('id');
    $('.deleteUrl').attr('href','{{route("users.verify", ["id" => ""]) }}'+id);
});
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