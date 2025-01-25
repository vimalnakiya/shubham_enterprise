<form class="row g-3 update_form" name="update_form" method="POST" id="update_form" action="{{route('categories.update')}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$book->id}}">
    <input type="hidden" name="old_image" value="{{$book->image}}">
    
    <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3">
        <div class="form-floating">
            <input type="text" class="form-control name" name="name" placeholder="" value="{{$book->name}}">
            <label for="name">Brand Name</label>
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