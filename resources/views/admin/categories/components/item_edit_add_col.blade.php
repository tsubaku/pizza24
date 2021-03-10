@php
    /** @var \App\Models\Category $item */
@endphp
<div class="card">
    <div class="card-body">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        Image
    </div>
    <div class="card-body">
        <div class="form-group">
            <img class="img-thumbnail" src="{{asset("storage/$item->ImageUrlPrepared")}}" alt="">
        </div>
    </div>
</div>




