@php
    /** @var \App\Models\Product $item */
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-header">
        Image
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ $item->image_url }}</h5>
        <p class="card-text">.......</p>
    </div>
</div>



