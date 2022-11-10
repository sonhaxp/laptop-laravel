

@for ($i = 0; $i < $attribute->count(); $i+=2)
<tr class="attribute_remove">
    <td class="form_name"><label for="{{ $attribute[$i]->attribute->Name }}">{{ $attribute[$i]->attribute->Name }}</label></td>
    <td class="form_text">
        <select id="{{ $attribute[$i]->attribute->AttributeId }}" name="{{ $attribute[$i]->attribute->AttributeId }}">
            <option selected="selected" value="">Chọn giá trị</option>
            @foreach ($attribute[$i]->Value as $temp)
            <option value="{{ $temp->AttributeValueId }}">{{ $temp->Value }}</option>     
            @endforeach
        </select>
    </td>
    @if ($i+1!=$attribute->count())
    <td class="form_name"><label for="{{ $attribute[$i+1]->attribute->Name }}">{{ $attribute[$i+1]->attribute->Name }}</label></td>
    <td class="form_text">
        <select id="{{ $attribute[$i+1]->attribute->AttributeId }}" name="{{ $attribute[$i+1]->attribute->AttributeId }}">
            <option selected="selected" value="">Chọn giá trị</option>
            @foreach ($attribute[$i+1]->Value as $temp)
            <option value="{{ $temp->AttributeValueId }}">{{ $temp->Value }}</option>     
            @endforeach
        </select>
    </td>
    @endif
</tr>
@endfor
