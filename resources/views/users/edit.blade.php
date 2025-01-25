<form class="row g-3 update_form" name="update_form" method="POST" id="update_form" action="{{route('products.update')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$book->id}}">
    <input type="hidden" name="old_image" value="{{$book->image}}">

    <div class="col-md-6">
        <div class="form-floating">
            <select class="form-select type" name="brand_id" aria-label="State">
                <option value="">Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ ($brand->id == $book->brand_id)?"selected":"" }}>{{ $brand->name }}</option>
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
                    <option value="{{ $category->id }}" {{ ($category->id == $book->category_id)?"selected":"" }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <label for="type">Select Category</label>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control name" name="name" placeholder="" value="{{$book->name}}">
            <label for="name">Brand Name</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control name" name="price" placeholder="" value="{{$book->price}}">
            <label for="name">Product Price</label>
        </div>
    </div>
   
    <div class="col-md-3">
        <label for="video_image">Image</label>
        <input class="form-control upload" id="upload" type="file" name="image">
    </div>
    <div class="image_preview" style="display:flex,height:10px"></div>

    <div class="text-center">
        <button type="submit" id="update" class="btn btn-primary save-btn" value="Update">Update</button>
        <button type="button" class="btn btn-danger save-btn cancel">Cancel</button>
    </div>
</form>
<script src="{{ asset('assets/admin/') }}/js/jquery-1.11.1.min.js" ></script>
<script src="{{ asset('assets/admin/') }}/js/jquery.validate.min.js"></script>