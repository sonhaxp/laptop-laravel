<option selected="selected" value="">Chọn thương hiệu</option>
@foreach ($brand as $item)
<option value="{{ $item->BrandId }}">{{ $item->brand->Name }}</option>     
@endforeach