@php
    /** @var \App\Models\Cart $item */
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title"><h3>Edit cart</h3></div>
                <div class="card-subtitle mb-2 text-muted"></div>

                <div class="form-group">
                    <label for="user_id">User id</label>
                    <input name="user_id" value="{{ old('user_id', $item->user_id) }}"
                           id="user_id" type="text" class="form-control" required disabled="disabled"
                    >
                </div>
                <div class="form-group">
                    <label for="session_id">Session_id</label>
                    <input name="session_id" value="{{ old('session_id',  $item->session_id) }}"
                           id="session_id" type="text"
                           class="form-control" disabled="disabled"
                    >
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" value="{{ old('name', $item->name) }}"
                           id="name" type="text" class="form-control" disabled="disabled"
                    >
                </div>
                <div class="form-group">
                    <label for="email">Phone</label>
                    <input name="email" value="{{ old('email', $item->email) }}"
                           id="email" type="text" class="form-control" disabled="disabled"
                    >
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input name="phone" value="{{ old('name', $item->phone) }}"
                           id="phone" type="text" class="form-control" disabled="disabled"
                    >
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input name="address" value="{{ old('address', $item->address) }}"
                           id="address" type="text" class="form-control" disabled="disabled"
                    >
                </div>

            </div>
        </div>
    </div>
</div>


