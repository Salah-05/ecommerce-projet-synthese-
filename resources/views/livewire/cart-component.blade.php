<div>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Your Cart
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            @if (session()->has('success_message'))
                            <div class="alert alert-success">
                                <strong>Success:</strong> <span style="font-weight: bold;">{{ session()->get('success_message') }}</span>
                            </div>
                            @endif
                            @if  (Cart::count() > 0)
                            <table class="table shopping-summery text-center clean">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach (Cart::content() as $item)
                                    <tr>
                                        <td class="image product-thumbnail"><img src="{{asset('assets/imgs/shop/chauss')}}{{$item->model->id}}.png" alt="#"></td>
                                        <td class="product-des product-name">
                                            <h5 class="product-name"><a href="product-details.html">{{$item->model->name}}</a></h5>
                                            {{-- <p class="font-xs">Maboriosam in a tonto nesciung eget<br> distingy magndapibus.
                                            </p> --}}
                                        </td>
                                        <td class="price" data-title="Price"><span>{{$item->model->regular_price}}</span></td>
                                        <td class="text-center" data-title="Stock">
                                            <div class="detail-qty border radius  m-auto">
                                                <a href="#" class="qty-down" wire:click.prevent="decreasequantity('{{$item->rowId}}')"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">{{$item->qty}}</span>
                                                <a href="#" class="qty-up" wire:click.prevent="increasequantity('{{$item->rowId}}')"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                        </td>
                                        <td class="text-right" data-title="Cart">
                                            <span>{{$item->subtotal}}</span>
                                        </td>
                                        <td class="action" data-title="Remove"><a href="#" class="text-muted" wire:click.prevent="destroy('{{$item->rowId}}')"><i class="fi-rs-trash"></i></a></td>
                                    </tr>
                                    @endforeach
                                   
                                    <tr>
                                        <td colspan="6" class="text-end">
                                            <a href="#" class="text-muted" wire:click.prevent="clearAll()"> <i class="fi-rs-cross-small"></i> Clear Cart</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                            <p>No item in Cart</p>
                            @endif
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-shuffle mr-10"></i>Update Cart</a>
                            <a class="btn "><i class="fi-rs-shopping-bag mr-10"></i>Continue Shopping</a>
                        </div>
                        <div class="row mb-50 d-flex flex-wrap">
                            <div class="col-lg-6 col-md-12 mb-3" style="flex: 1;">
                                <div class="heading_s1 mb-3">
                                    <h4>Calculate Shipping</h4>
                                </div>
                                <p class="mt-15 mb-30">Flat rate: <span class="font-xl text-brand fw-900">5%</span></p>
                                
                                <div>
                                    {{-- <form class="field_form shipping_calculator" action="{{ route('ajouterCart') }}" method="POST" @if($cvv) style="display:none" @endif> --}}
                                        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                                        <div class="row mb-50">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="heading_s1 mb-3">
                                                    <h4>Information Card</h4>
                                                </div>
                                    <form class="field_form shipping_calculator" action="{{ route('ajouterCart') }}" method="POST" >
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <div class="custom_select">
                                                    <!-- Additional content can go here -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row row">
                                            <div class="form-group col-lg-6">
                                                <input required="required" placeholder="CVV" name="CVV" type="{{$modeinfo}}" value="{{ $cvv }}" @if($cvv) disabled @endif>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <input required="required" placeholder="Numero de cart"  name="numero_de_cart" type="{{$modeinfo}}" value="{{ $numero_du_cart }}" @if($numero_du_cart) disabled @endif>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <button type="submit"  class="btn btn-sm" style="background-color: rgb(59, 59, 83);display:{{$modeblock}}" @if($cvv || $numero_du_cart) disabled @endif>Confirme</button>
                                        </form>

                                               <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Update
                                                </button>
                                                
                                                <!-- Modal -->
                                                <form class="field_form shipping_calculator" action="{{ route('modifiercart',$id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit card information</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                 <div class="form-group col-lg-6">
                                                                     <input required="required" placeholder="CVV" name="CVV" value="{{ $cvv }}" >
                                                                 </div>
                                                                 <div class="form-group col-lg-6">
                                                                     <input required="required" placeholder="Numero de cart" name="numero_de_cart" type="text" value="{{ $numero_du_cart }}" >
                                                                 </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">confirm</button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <script>
                                            // function edite() {
                                            //     document.getElementById('CVV').removeAttribute('disabled');
                                            //     document.getElementById('Numero').removeAttribute('disabled');
                                            //     document.getElementById('sub').removeAttribute('disabled');
                                            // }
                                            document.addEventListener('DOMContentLoaded', function() {
                                                @if ($errors->any())
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        html: '{!! implode('<br>', $errors->all()) !!}'
                                                    });
                                                @endif
                                    
                                                @if (session('success'))
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success',
                                                        text: '{{ session('success') }}'
                                                    })
                                                @endif
                                            });
                                        </script>
                                @error('couponCode')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                                <div class="mb-30 mt-50" style="display:{{$mode}}">
                                    <div class="heading_s1 mb-3">
                                        <h4>Apply Coupon</h4>
                                    </div>
                                    <div class="total-amount">
                                        <div class="left">
                                            <div class="coupon">
                                                <form wire:submit.prevent="applyCoupon">
                                                    <div class="form-row row justify-content-center">
                                                        <div class="form-group col-lg-6">
                                                            <input wire:model="couponCode" class="font-medium" name="coupon" placeholder="Enter Your Coupon">
                                                            
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <button type="submit" class="btn btn-sm"><i class="fi-rs-label mr-10"></i>Apply</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3" style="flex: 1; display:{{$mode}}">
                                <form action="{{ route('addcommande') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total" value="{{ Cart::total() }}">
                                    <input type="hidden" name="content" value="{{ json_encode(Cart::content()) }}">
                                    <div class="border p-md-4 p-30 border-radius cart-totals">
                                        <div class="heading_s1 mb-3">
                                            <h4>Cart Totals</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td class="cart_total_label">Cart Subtotal</td>
                                                        <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">{{ Cart::subtotal() }} Mad</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="cart_total_label">Tax</td>
                                                        <td class="cart_total_amount"><span class="font-lg fw-900 text-brand">{{ Cart::tax() }} Mad</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="cart_total_label">Shipping</td>
                                                        <td class="cart_total_amount"> <i class="ti-gift mr-5"></i> Free Shipping</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="cart_total_label">Total</td>
                                                        <td class="cart_total_amount"><strong><span class="font-xl fw-900 text-brand">{{ Cart::total() }} Mad</span></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn"><i class="fi-rs-box-alt mr-10"></i> Proceed To CheckOut</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
            </div>
        </section>
    </main>
</div>
