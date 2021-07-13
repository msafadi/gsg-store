    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="form-group">
        <label for="">Product Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}">
        @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <x-form-select name="category_id" label="Category" :options="$categories" :selected="$product->category_id" />
    </div>
    <div class="form-group">
        <label for="">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $product->description) }}</textarea>
        @error('description')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Image</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
        @error('image')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <x-form-input type="text" name="sku" label="SKU" :value="$product->sku" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="price" label="Price" :value="$product->price" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="sale_price" label="Sale Price" :value="$product->sale_price" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="quantity" label="Quantity" :value="$product->quantity" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="weight" label="Weight" :value="$product->weight" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="width" label="Width" :value="$product->width" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="height" label="Height" :value="$product->height" />
    </div>
    <div class="form-group">
        <x-form-input type="number" name="length" label="Length" :value="$product->length" />
    </div>
    
    <div class="form-group">
        <label for="status">Status</label>
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-active" value="active" @if(old('status', $product->status) == 'active') checked @endif>
                <label class="form-check-label" for="status-active">
                    Active
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft" @if(old('status', $product->status) == 'draft') checked @endif>
                <label class="form-check-label" for="status-draft">
                    Draft
                </label>
            </div>
        </div>
        @error('status')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
    </div>