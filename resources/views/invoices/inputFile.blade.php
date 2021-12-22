<div class="fileinput fileinput-new text-center" data-provides="fileinput">
    <div class="justify-content-center">
        <span class="btn btn-rose btn-sm btn-file">
            <span class="fileinput-new">
                @if ($file)
                    {{ __('Reemplazar archivo') }}
                @else
                    {{ __('Agregar archivo') }}
                @endif
            </span>
            <span class="fileinput-exists">Cambiar archivo</span>
            <input type="file" name="{{ $name }}">
        </span>
    </div>
    @include('partials.errorsession',[$field=$name])
</div>
