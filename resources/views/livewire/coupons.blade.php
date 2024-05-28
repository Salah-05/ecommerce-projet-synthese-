<div style="padding: 30px">
    <center>
        <table style="width: 500px">
            <tr>
                <th >code coupon</th>
                <th>prix</th>
            </tr>
           @foreach ($coupons as $coupon)
            <tr>
                <td class="coupon-code" style="cursor:pointer" data-code="{{ $coupon->code }}" title="Click to copy coupon code">{{$coupon->code}}</td>
                <td>{{$coupon->prix}} DH</td>
            </tr>
           @endforeach
        </table>
        {{ $coupons->links() }}
    </center>
</div>

<script>
    // Get all elements with the class 'coupon-code'
    const couponCodes = document.querySelectorAll('.coupon-code');

    // Add click event listener to each coupon code element
    couponCodes.forEach(coupon => {
        coupon.addEventListener('click', () => {
            // Copy coupon code to clipboard
            const codeToCopy = coupon.dataset.code;
            navigator.clipboard.writeText(codeToCopy);

            // Display message when code is copied
            const message = document.createElement('span');
          
            coupon.appendChild(message);

            // Remove message after a short delay
            setTimeout(() => {
                message.remove();
            }, 2000);
        });
    });
</script>
