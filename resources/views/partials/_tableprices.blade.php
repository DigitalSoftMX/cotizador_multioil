<tr>
    <td class="font-weight-bold">{{ $product }}</td>
    <td>
        <input class="form-control" id="{{ 'price_' . $p }}" name="{{ 'price_' . $p }}" type="number" value=""
            step="any" placeholder="0.00" readonly required />
    </td>
    <td>
        <input class="form-control" id="{{ 'liters_' . $p }}" name="{{ 'liters_' . $p }}" type="number" value=""
            step="any" placeholder="0.00" />
    </td>
    <td>
        <input class="form-control" id="{{ 'total_' . $p }}" name="{{ 'total_' . $p }}" type="text" value=""
            step="any" placeholder="0.00" readonly required />
    </td>
</tr>
