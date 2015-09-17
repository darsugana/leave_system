@if($errors->has($field))
    <span class="label label-danger">{{ $errors->first($field) }}</span>
@endif
