@if (isset($label))
<label for="{{ $id ?? $name }}">{{ $label }}</label>
@endif
        <select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control @error($name) is-invalid @enderror">
            <option value=""></option>
            @foreach ($options as $value => $text)
            <option value="{{ $value }}" @if($value == old($name, ($selected ?? null))) selected @endif>{{ $text }}</option>
            @endforeach
        </select>
        @error($name)
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror