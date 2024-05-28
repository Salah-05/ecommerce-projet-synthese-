<div>
    {{-- <form class="field_form shipping_calculator" action="{{ route('ajouterCart') }}" method="POST" @if($cvv) style="display:none" @endif> --}}
        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
        <div class="row mb-50">
            <div class="col-lg-6 col-md-12">
                <div class="heading_s1 mb-3">
                    <h4>Calculate Shipping</h4>
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
                <input required="required" placeholder="CVV" name="CVV" type="text" value="{{ $cvv }}" @if($cvv) disabled @endif>
            </div>
            <div class="form-group col-lg-6">
                <input required="required" placeholder="Numero de cart" name="numero_de_cart" type="text" value="{{ $numero_du_cart }}" @if($numero_du_cart) disabled @endif>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-12">
                <button class="btn btn-sm"><i class="fi-rs-shuffle mr-10"></i>Update</button>
                <button type="submit"  class="btn btn-sm" style="background-color: rgb(59, 59, 83)" @if($cvv || $numero_du_cart) disabled @endif>Confirmer</button>
            </div>
        </div>
    </form>
    {{-- update --}}
    
    {{-- <form class="field_form shipping_calculator" action="{{ route('modifiercart') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-lg-12">
                <div class="custom_select">
                </div>
            </div>
        </div>
        <div class="form-row row">
            <div class="form-group col-lg-6">
                <input required="required" id="CVV" placeholder="CVV" name="CVV" type="text" value="{{ $cvv }}" @if($cvv) disabled @endif>
            </div>
            <input type="hidden" name="id_cart" value="{{ $id_cart }}">

            <div class="form-group col-lg-6">
                <input required="required" id="Numero" placeholder="Numero de cart" name="numero_de_cart" type="text" value="{{ $numero_du_cart }}" @if($numero_du_cart) disabled @endif>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-12">
                <button class="btn btn-sm" onclick="edite()" type="button"><i class="fi-rs-shuffle mr-10"></i>Editer</button>
                <button type="submit" id="sub" class="btn btn-sm" style="background-color: rgb(59, 59, 83)" @if($cvv || $numero_du_cart) disabled @endif>Confirmer</button>
            </div>
        </div>
    </form> --}}

    <!-- SweetAlert for error and success messages -->

     
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
    
</div>
