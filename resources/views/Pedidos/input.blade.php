<label class="color1">Regular:</label>
<input class="form-control" name="regular{{ $day }}" id="regular{{ $day }}" type="number"
    onKeyUp="Suma()" placeholder="Cantidad en litros." value="{{ old("regular{$day}") }}" required="true">
<label class="color2">Premium:</label>
<input class="form-control" name="premium{{ $day }}" id="premium{{ $day }}" type="number"
    onKeyUp="Suma()" placeholder="Cantidad en litros." value="{{ old("premium{$day}") }}" required="true">
<label class="color3">Diésel:</label>
<input class="form-control" name="diesel{{ $day }}" id="diesel{{ $day }}" type="number"
    onKeyUp="Suma()" placeholder="Cantidad en litros." value="{{ old("diesel{$day}") }}" required="true">
