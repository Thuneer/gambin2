<!-- Flash Message+ -->
@if (Session::has('message'))
    <div class="message">

        <div class="message__icon @if (Session('status') == 'error') message__icon--error @endif">

            @if (Session('status') == 'success')<i class="fas fa-check"></i> @else
                <i class="fas fa-times"></i> @endif
        </div>
        <div class="message__text">
            {!! Session('message') !!}
        </div>

    </div>
@endif