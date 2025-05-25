{{-- <div class="col-lg-3"> --}}
{{-- {{ dd($store[0]->user->promoteur->phone) }} --}}
<div class="product-sidebar">
    <div class="product-single-sidebar-item">

        <div class="product-single-author">

            <img src="{{ asset($store[0]->logo ? 'uploads/store_logos/' . $store[0]->logo : 'assets/img/account/user.jpg') }} "
                alt="">
            <h6><a href="#">{{ $store[0]->store_name }} </a></h6>
            {{-- <span>{{ $store[0]->store_email }}</span> --}}
            @if($store[0]->type=="promoteur")
            @if (isset($store[0]->user->promoteur->phone) && !empty($store[0]->user->promoteur->phone))
                <div class="product-single-author-phone">
                    <span>
                        <i class="far fa-phone"></i>
                        <span class="author-number">
                            {{-- {{ dd($user) }} --}}
                            {{ substr($store[0]->user->promoteur->phone, 0, 6) }}XXXX</span>
                        <span class="author-reveal-number">{{ $store[0]->user->promoteur->phone }}</span>
                    </span>
                    <p data-user-id="{{ $store[0]->user->id }}"
                    id="display-number-button">Cliquez pour afficher le N° de téléphone</p>
                </div>
                <a href="tel:{{ $store[0]->user->promoteur->phone ?? $store[0]->user->promoteur->mobile}}" class="theme-border-btn w-100 mt-4" id="call-button"
                                                data-user-id="{{ $store[0]->user->id }}"
                                                data-phone="{{ $store[0]->user->promoteur->phone ?? $store[0]->user->promoteur->mobile }}"><i
                        class="far fa-phone"></i>
                    Appeller</a>
            @endif
            @else

            @if (isset($store[0]->user->company->mobile) && !empty($store[0]->user->company->mobile))

                <div class="product-single-author-phone">
                    <span>
                        <i class="far fa-phone"></i>
                        <span class="author-number">
                            {{-- {{ dd($user) }} --}}
                            {{ substr($store[0]->user->company->mobile, 0, 6) }}XXXX</span>
                        <span class="author-reveal-number">{{ $store[0]->user->company->mobile }}</span>
                    </span>
                    <p data-user-id="{{ $store[0]->user->id }}"
                    id="display-number-button">Cliquez pour afficher le N° de téléphone</p>
                </div>
                <a href="tel:{{ $store[0]->user->company->mobile  ?? $store[0]->user->company->phone }}" class="theme-border-btn w-100 mt-4" id="call-button"
                data-user-id="{{ $store[0]->user->id }}" data-phone="{{ $store[0]->user->company->mobile  ?? $store[0]->user->company->phone }}"><i
                        class="far fa-phone"></i>
                    Appeller</a>
            @endif
            @endif
            <div class="d-flex">
            @if (isset($store[0]->fb_link) && !empty($store[0]->fb_link))
                <a href="{{ $store[0]->fb_link }}" class="w-100 mt-4"><img src="{{ asset('icon_png/facebook.png') }}"
                        alt="" style="
                            width: 25px;
                        ">
                </a>
            @endif

            @if (isset($store[0]->site_link) && !empty($store[0]->site_link))
                <a href="{{ $store[0]->site_link }}" class="w-100 mt-4"><img src="{{ asset('icon_png/site.jpg') }}"
                        alt="" style="
                            width: 31px;
                        ">
                </a>
            @endif
        </div>

        </div>
    </div>
</div>
<form id="call-action-form" method="POST" action="{{ route('save_statistique') }}" style="display: none;">
        @csrf
        <input type="hidden" name="user_id" id="user-id-input">
        <input type="hidden" name="action_type" value="call">
        <input type="hidden" name="phone" id="phone-input">
    </form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {


            $('#call-button').on('click', function(e) {
                e.preventDefault(); // Prevent the default button action
                // alert("ee");
                // Get the data attributes
                var userId = $(this).data('user-id');
                var phone = $(this).data('phone');
                console.log("User ID: " + userId);
                console.log("Phone: " + phone);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                // Set the form inputs
                console.log(csrfToken);

                $('#user-id-input').val(userId);
                $('#phone-input').val(phone);
                // console.log("Submitting Data:", $('#call-action-form').attr('action'));
                // Submit the form
                // alert("ee222");
                $.ajax({
                    type: 'POST',
                    url:  "{{ route('save_statistique') }}",
                    // data: $('#call-action-form').serialize(),
                    data: {
                        _token: csrfToken,
                        user_id: userId,
                        action_type: "call"
                    },
                    success: function(response) {
                        // console.error("Error submitting form:gooodd",response.success);

                        // On success, redirect to the dialer
                        window.location.href = 'tel:' + phone;
                    },
                    error: function(xhr, status, error) {
                        console.error("Error submitting form:", error);
                        // Optionally, handle the error
                        console.error("Error submitting form:", xhr.responseText);
                    }
                });
            });


            $('#display-number-button').on('click', function() {
                var userId = $(this).data('user-id');
                // console.log(userId);

                var action = 'displayed_number';

                $.ajax({
                    url: "{{ route('save_statistique') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId,
                        action_type: action
                    },

                });
            });
        });
    </script>
