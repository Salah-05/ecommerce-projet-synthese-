<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<div class="comment-list">
    
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div>
            <div class="col-12">
                <div class="form-group">
                    <textarea class="form-control w-100" name="message" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                </div>
            </div>
            <input type="hidden" name="stars" id="star-rating" value="0">
            <input type="hidden" name="pr_id" id="star-rating" value={{$pr_id}}> 
        </div>
        <div id="star-container">
            @for ($i = 1 ; $i <= 5 ; $i++ )
                <i class="fa-regular fa-star" data-value="{{ $i }}" name="stars"></i>
            @endfor
        </div>
        <button type="submit" style="transform: scale(0.67); margin-left: -20px; margin-top: 10px;">Submit</button>

    </form>
    <hr>

    @foreach ($comments as $comment)
    <div class="single-comment justify-content-between d-flex">
        <div class="user justify-content-between d-flex">
            <div class="thumb text-center">
                {{-- <img src="{{asset('assets/imgs/page/avatar-6.jpg" al')}}" alt="#"> --}}
                <h6><a href="#">{{$comment->user->name}}</a></h6>
                <p class="font-xxs">{{$comment->created_at}}</p>
            </div>
            <div class="desc">
                     @php
                        $filledStars = min(5, $comment->stars); // To prevent showing more than 5 stars
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $filledStars)
                            <i class="fas fa-star text-warning" style="transform:scale(0.8);cursor:alias"></i>
                        @else
                            <i class="far fa-star text-warning" style="transform:scale(0.8);cursor:alias"></i>
                        @endif
                    @endfor
                <p>{{$comment->message}}</p>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <p class="font-xs mr-30">{{$comment->created_at->format('F j, Y \a\t g:i a')}}</p>
                        {{-- <a href="#" class="text-brand btn-reply">Reply <i class="fi-rs-arrow-right"></i> </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#star-container .fa-star').on('click', function() {
            var rating = $(this).data('value');
            $('#star-rating').val(rating);

            $('#star-container .fa-star').each(function() {
                var starValue = $(this).data('value');
                if (starValue <= rating) {
                    $(this).addClass('fas').removeClass('fa-regular'); // Change to solid star
                } else {
                    $(this).addClass('fa-regular').removeClass('fas'); // Change to regular star
                }
            });
        });
    });
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

<style>
     .fa-star {
        cursor: pointer;
        font-size: 1.5em;
        color: grey;
    }
    .fa-star.fas {
        color: rgb(255, 200, 0);
    }
    .forms{
        display: flex;
        flex-direction: row;
    }
    .group {
 position: relative;
}

.input {
 font-size: 16px;
 padding: 10px 10px 10px 5px;
 display: block;
 width: 200px;
 border: none;
 border-bottom: 1px solid #515151;
 background: transparent;
}

.input:focus {
 outline: none;
}

label {
 color: #999;
 font-size: 18px;
 font-weight: normal;
 position: absolute;
 pointer-events: none;
 left: 5px;
 top: 10px;
 transition: 0.2s ease all;
 -moz-transition: 0.2s ease all;
 -webkit-transition: 0.2s ease all;
}

.input:focus ~ label, .input:valid ~ label {
 top: -20px;
 font-size: 14px;
 color: #5264AE;
}

.bar {
 position: relative;
 display: block;
 width: 200px;
}

.bar:before, .bar:after {
 content: '';
 height: 2px;
 width: 0;
 bottom: 1px;
 position: absolute;
 background: #5264AE;
 transition: 0.2s ease all;
 -moz-transition: 0.2s ease all;
 -webkit-transition: 0.2s ease all;
}

.bar:before {
 left: 50%;
}

.bar:after {
 right: 50%;
}

.input:focus ~ .bar:before, .input:focus ~ .bar:after {
 width: 50%;
}

.highlight {
 position: absolute;
 height: 60%;
 width: 100px;
 top: 25%;
 left: 0;
 pointer-events: none;
 opacity: 0.5;
}

.input:focus ~ .highlight {
 animation: inputHighlighter 0.3s ease;
}

@keyframes inputHighlighter {
 from {
  background: #5264AE;
 }

 to {
  width: 0;
  background: transparent;
 }
}
</style>