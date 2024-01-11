@extends('templates.app')
@section('content')
<section class="min-vh-100">
    <div class="container h-100 py-5">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-10">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-normal mb-0 text-black">Корзина</h3>
            <span>Элементов в корзине: <span id="totalAmount">{{$total_amount}}</span></span>
            <span>Итого: <span id="totalCost" type="text"></span>₽</span>
          </div>
        @foreach ($orders as $order)
          @if ($order->user_id == auth()->id())
          @foreach ($products as $product)
            @if ($product->id == $order->product_id)
          <div class="card rounded-3 mb-4 card-product shadow " data-card="{{$product->id}}">
            <div class="card-body p-4">
              <div class="row d-flex justify-content-between align-items-center">
                <div class="col-md-2 col-lg-2 col-xl-2">
                  <img
                    src="{{$product->getProductImage()->url}}"
                    class="img-fluid rounded-3" alt="">
                </div>
                <div class="col-md-3 col-lg-3 col-xl-3">
                  <p class="lead fw-normal mb-2">{{$product->full_name}}</p>
                </div>
                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                  <button class="btn px-2 remCartBtn" data-id="{{$product->id}}">
                    -
                  </button>
                  <input disabled min="1" data-count="{{$product->id}}" name="quantity" value="{{$order->quantity}}" type="number"
                    class="form-control form-control-sm" />
                  <button class="btn px-2 addCartBtn" data-id="{{$product->id}}">
                    +
                  </button>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                  <h5 class="mb-0 costValue" data-cost="{{$product->id}}">{{$product->price * $order->quantity}}₽</h5>
                </div>
                <div data-price="{{$product->id}}" hidden>
                    {{$product->price}}
                </div>
                <div data-stock="{{$product->id}}" hidden>
                    {{$product->count}}
                </div>

                <div class="col-md-1 col-lg-1 col-xl-1 text-end" data-destroy="{{$product->id}}">
                  <a href="#" data-destroy="{{$product->id}}" class="text-danger dltBtn"><svg data-destroy="{{$product->id}}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path data-destroy="{{$product->id}}" d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                  </svg></a>
                </div>

              </div>
            </div>
          </div>
                @endif
            @endforeach
          @endif
        @endforeach
            <div class="d-flex justify-content-end">
              <button type="button" class="btn text-white btn-warning btn-lg ms-3 acceptBtn">Оформить заказ</button>
              <span hidden class="text-danger empty-cart">Корзина пуста</span>
            </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('script')
    <script src="{{asset('/js/script.js')}}"></script>
    <script>
        let totalAmount = parseInt(document.querySelector('#totalAmount').textContent);
        function getCost(){
            let cost = 0
            const arr1 = document.querySelectorAll('.costValue');
            arr1.forEach((item)=>{
                cost += parseFloat(item.textContent);
            });
            document.querySelector('#totalCost').textContent = cost;
        }
        const arr = [...document.querySelectorAll('.addCartBtn'), ...document.querySelectorAll('.remCartBtn')];
        arr.forEach((btn)=>{
            btn.addEventListener('click', async (e) => {
                    const price = parseFloat(document.querySelector(`[data-price="${e.target.dataset.id}"]`).textContent);
                    const stock = parseInt(document.querySelector(`[data-stock="${e.target.dataset.id}"]`).textContent);
                    let cost = document.querySelector(`[data-cost="${e.target.dataset.id}"]`);
                    let value = parseFloat(cost.textContent);
                    const countInp = document.querySelector(`[data-count="${e.target.dataset.id}"]`);
                    let count = countInp.value;
                    e.preventDefault();
                    if(btn.classList.contains('addCartBtn')){
                        if(count != stock){
                            count++;
                            totalAmount++;
                            cost.textContent = `${((value + price).toFixed(2))}₽`;
                            await postJson('{{route('cart.add')}}', e.target.dataset.id, '{{csrf_token()}}');
                        }
                    } else if (btn.classList.contains('remCartBtn')){
                        if(count != 1){
                            count--;
                            totalAmount--;
                            cost.textContent = `${((value - price).toFixed(2))}₽`;
                            await postJson('{{route('cart.remove')}}', e.target.dataset.id, '{{csrf_token()}}');
                        }
                    }
                    countInp.value = count;
                    document.querySelector('#totalAmount').textContent = totalAmount;
                    getCost();
            });
        });
        [...document.querySelectorAll('.dltBtn')].forEach((btn)=>{
            btn.addEventListener('click', async (e)=>{
                const countInp = document.querySelector(`[data-count="${e.target.dataset.destroy}"]`);
                let count = countInp.value;
                document.querySelector(`[data-card="${e.target.dataset.destroy}"]`).remove();
                totalAmount = totalAmount - count;
                document.querySelector('#totalAmount').textContent = totalAmount;
                getCost();
                await postJson('{{route('cart.destroy')}}', e.target.dataset.destroy, '{{csrf_token()}}');
            });
        });
        document.querySelector('.acceptBtn').addEventListener('click', async (e)=>{
          if([...document.querySelectorAll('.card-product')].length !== 0){
            e.preventDefault();
            let response = await postJson('{{route('cart.order')}}', 0, '{{csrf_token()}}');
            if(response == 0){
                window.location.replace("http://127.0.0.1:8000/orders");
            }
          }
          else document.querySelector('.empty-cart').hidden = false;
        })
        document.addEventListener('DOMContentLoaded', getCost)
    </script>
@endpush
