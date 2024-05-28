<div class="m-5">
  <h5 class="text-danger m-2">Delivery will be in 15 days, and you can cancel the order up to 3 days before delivery</h5> <br>
  <table class="table">
      <thead>
          <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
              <th scope="col">Subtotal</th>
          </tr>
      </thead>
      <tbody>
          @php
              $total = 0; // Initialize total variable
          @endphp
          @foreach ($commandes as $commande)
              @foreach ($commande->products as $product)
                  @php
                      $subtotal = $product->sale_price * $product->pivot->qte; // Calculate subtotal for each product
                      $total += $subtotal; // Add subtotal to total
                  @endphp
                  <tr>
                      <td class="image product-thumbnail">
                          <img src="{{ asset('assets/imgs/shop/chauss') . $product->id . '.png' }}" alt="#">
                      </td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->sale_price }} DH</td>
                      <td>{{ $product->pivot->qte }}</td>
                      <td>{{ $subtotal }}</td>
                  </tr>
              @endforeach
          @endforeach
          <tr>
              <td colspan="4" class="text-right">Total:</td>
              <td>{{ $total }} DH</td>
          </tr>
      </tbody>
     <div class="m-2">
      @if ($commande->created_at->diffInDays(now()) <= 3)
      <form action="{{ route('cancel') }}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden" name='id' value={{$commande->id}}>
          <button type="submit" class="btn btn-danger">Cancel Order</button>
      </form>
  @endif
     </div>
  </table>
  <div class="pagination-links">
    {{ $commandes->links() }}
</div>
</div>
