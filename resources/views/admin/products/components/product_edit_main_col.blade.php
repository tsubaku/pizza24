@php
    /** @var \App\Models\Product $item */
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                {{$item->is_published ? 'Published' : 'Draft' }}
            </div>

            <div class="card-body">
                <div class="card-title"><h3>Edit product</h3></div>
                <div class="card-subtitle mb-2 text-muted"></div>

                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" value="{{ old('title', $item->title) }}"
                           id="title" type="text" class="form-control" minlenght="3" required
                    >
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input name="slug" value="{{ old('slug',  $item->slug) }}"
                           id="slug" type="text"
                           class="form-control"
                    >
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" value="{{ $item->category_id }}"
                            id="category_id" type="text" class="form-control"
                            placeholder="Select category" required>
                        @foreach($categoryList as $categoryOption)
                            <option value="{{ $categoryOption->id }}"
                                {{$categoryOption->id == $item->category_id ? 'selected' : '' }}>
                                {{$categoryOption->title}}
                            </option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" type="text"
                                  class="form-control" placeholder="description"
                        >{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input name="price" value="{{ old('price', $item->price) }}"
                               id="price" type="text" class="form-control"
                        >
                    </div>

                    <div class="form-group">
                        <label for="image">Select product image</label>
                        <input name="image" value="{{ old('image_url', $item->image_url) }}"
                               id="image" type="file" class="form-control">
                    </div>


                    <div class="form-check">
                        <input name="is_published" type="hidden" value="0">
                        <input name="is_published" type="checkbox" class="form-check-input"
                               value="1"
                            {{ old('is_published', $item->is_published) ? 'checked="checked"' : '' }}
                        >
                        <label class="form-check-label" for="is_published">Published</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


