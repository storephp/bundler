<div {{ $attributes->merge(['class' => 'mb-3 row']) }} {{ $attributes }}>
    <label class="col-3 col-form-label @if ($required) required @endif">{{ $label }}</label>
    <div class="col">
        <label class="form-check">
            <input type="checkbox" class="form-check-input @error($model) is-invalid @enderror"
                placeholder="{{ $placeholder }}" wire:model.defer="{{ $model }}">
            <span class="form-check-label">{{ $hint }}</span>
        </label>
        @error($model)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
