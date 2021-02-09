@php
    /** @var \App\Models\Category $item */
    /** @var Illuminate\Support\Collection $categoryList */
@endphp

<div class="card">
    <div class="card-body">
        <div class="card-title"></div>
        <h3>Edit category</h3>
        <div class="tab-content">
            <div class="tab-pane active" id="maindata" role="tabpanel">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" value="{{ $item->title }}"
                           id="title" type="text" class="form-control" minlenght="3" required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input name="slug" value="{{ $item->slug }}"
                       id="slug" type="text" class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="parent_id">Parent</label>
                <select name="parent_id" value="{{ $item->title }}"
                        id="parent_id" type="text"
                        class="form-control" placeholder="Выберите категорию"
                        required>
                    @foreach($categoryList as $categoryOption)
                        <option value="{{ $categoryOption->id }}"
                                @if($categoryOption->id == $item->parent_id) selected="selected" @endif >
                            {{$categoryOption->idTitle}}
                        </option>
                        categoryOption->id={{$categoryOption->id}}
                        item->parent_id={{$item->parent_id}}
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" value="{{ $item->title }}"
                          id="description" type="text"
                          class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
            </div>

        </div>
    </div>
</div>


