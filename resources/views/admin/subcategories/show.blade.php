@extends('templates.admin')
@section('content')
<h2>Товары по подкатегории {{$products[0]->subcategories[0]->name}}</h2>
<div class="scroll-table">
	<table>
		<thead>
			<tr>
				<th>Название</th>
				<th>Цена</th>
				<th>Количество</th>
				<th>Страна</th>
				<th>Категория</th>
                <th>Подкатегории</th>
                <th>Действия</th>
			</tr>
		</thead>
	</table>
	<div class="scroll-table-body">
		<table>
			<tbody>
                @foreach ($products as $product)
                <tr>
					<td>{{$product->full_name}}</td>
					<td>{{$product->price}}</td>
					<td>{{$product->count}}</td>
					<td>{{$product->country->name}}</td>
					<td>{{$product->product_category}}</td>
                    <td>
                        @foreach ($product->subcategories as $subcategory)
                            <span>{{$subcategory->name}}</span><br>
                        @endforeach
                    </td>
                    <td class="d-flex justify-content-around">
                        <a href="{{route('admin.products.edit', $product->id)}}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                          </svg></a>
                        <form action="{{route('admin.products.destroy', $product->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                              </svg></button>
                        </form>
                    </td>
				</tr>
                @endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
