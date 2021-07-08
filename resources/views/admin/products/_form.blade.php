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
        <label for="">Category</label>
        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if($category->id == old('category_id', $product->category_id)) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
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
        <label for="sku">SKU</label>
        <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{ old('sku', $product->sku) }}">
        @error('sku')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}">
        @error('price')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="sale_price">Sale Price</label>
        <input type="number" class="form-control @error('sale_price') is-invalid @enderror" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
        @error('sale_price')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $product->quantity) }}">
        @error('quantity')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="weight">Weight</label>
        <input type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight', $product->weight) }}">
        @error('weight')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="width">Width</label>
        <input type="number" class="form-control @error('width') is-invalid @enderror" name="width" value="{{ old('width', $product->width) }}">
        @error('width')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="height">Height</label>
        <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" value="{{ old('height', $product->height) }}">
        @error('height')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="length">Length</label>
        <input type="number" class="form-control @error('length') is-invalid @enderror" name="length" value="{{ old('length', $product->length) }}">
        @error('length')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
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