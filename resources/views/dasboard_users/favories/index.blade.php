@extends('layouts.dashboard')
@section('pageTitle')
    Tous les Favoris
@endsection
@section('sectionTitle')
    Tous les Favoris
@endsection
@section('content')
{{-- {{ Route::current()->getName() }} --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="user-profile-wrapper">
        <div class="user-profile-card profile-favorite">
            {{-- <div class="user-profile-card-header"> --}}
            <h4 class="user-profile-card-title">Mes Favoris</h4>


            {{-- </div> --}}
            <div class="row">
                @if (count($favorites) > 0)
                    @foreach ($favorites as $favorite)
                        {{-- {{dd($favorite)}} --}}

                        <div class="col-md-6 col-lg-4">
                            @if ($favorite->favoritable_type == 'App\Models\PromoteurProperty')
                                <div class="product-item">
                                    <div class="product-img">
                                        <span
                                            class="product-status featured">{{ strtoupper($favorite->favoritable->ref) }}</span>

                                        @if ($favorite->favoritable->getFirstImageOrDefault())
                                            <img src="{{ asset('uploads/promoteur_property/' . $favorite->favoritable->getFirstImageOrDefault()) }}"
                                                alt="">
                                        @else
                                            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="">
                                        @endif
                                        <a href="#"
                                            class="product-favorite">{{ ucfirst($favorite->favoritable->category->name) }}
                                            {{ $favorite->favoritable->operation->title }}</a>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-top">
                                            <div class="product-category">
                                                <div class="product-category-icon">
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <h6 class="product-category-title"><a
                                                        href="#">{{ ucfirst($favorite->favoritable->user->promoteur->first_name . ' ' . $favorite->favoritable->user->promoteur->last_name) }}
                                                    </a></h6>
                                            </div>
                                            {{-- <div class="product-rate">
                                            <i class="fas fa-star"></i>
                                            <span>4.5</span>
                                        </div> --}}
                                        </div>
                                        <div class="product-info">
                                            {{-- <h5><a href="#">{{ $favorite->favoritable->title }}</a></h5> --}}
                                            <p
                                                style="
                                                margin-top: -12px;
                                                margin-left: -4px;
                                            ">
                                                <img src="{{ asset('icon_png/location.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $favorite->favoritable->city->name }} ,
                                                {{ $favorite->favoritable->area->name }}
                                            </p>


                                            <div class="product-date"
                                                style="
                                                        margin-top: -12px;
                                                        margin-left: -4px;
                                                    ">
                                                <img src="{{ asset('icon_png/m22.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $favorite->favoritable->surface_totale }} m²
                                            </div>


                                            <div class="product-date"
                                                style="
                                                            margin-top: -12px;
                                                            margin-left: -4px;
                                                        ">
                                                <img src="{{ asset('icon_png/calendar.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $favorite->favoritable->created_at }}
                                            </div>
                                        </div>
                                        <div class="product-bottom">
                                            <div class="product-price">

                                                {{ $favorite->favoritable->price_total }} DT


                                            </div>

                                            <a href="{{ route('prop_info_promoteur', $favorite->favoritable->slug) }}"
                                                class="product-text-btn" style="font-size:12px">View Details <i
                                                    class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @elseif($favorite->favoritable_type == 'App\Models\Property')
                                {{-- <div class="col-md-6 "> --}}
                                <div class="product-item">
                                    <div class="product-img">
                                        <span
                                            class="product-status featured">{{ strtoupper($favorite->favoritable->ref) }}</span>
                                        {{-- @if ($favorite->favoritable->main_picture) --}}
                                        @if (isset($favorite->favoritable->main_picture) &&
                                                isset($favorite->favoritable->main_picture) &&
                                                isset($favorite->favoritable->main_picture->alt) &&
                                                file_exists(public_path('uploads/main_picture/images/properties/' . $favorite->favoritable->main_picture->alt)))
                                            {{-- <img src="{{ asset('uploads/main_picture/images/properties/' . $favorite->favoritable->main_picture->alt) }}" alt=""> --}}
                                            {{-- added for test width and height --}}
                                            <?php
                                            $imagePath = asset('uploads/main_picture/images/properties/' . $favorite->favoritable->main_picture->alt);
                                            [$width, $height] = getimagesize(public_path('uploads/main_picture/images/properties/' . $favorite->favoritable->main_picture->alt));
                                            
                                            $style = $width < 410 && $height < 292 ? 'width: 410px; height: 292px;' : '';
                                            // $style = '';
                                            // if ($width < 410 && $height < 292) {
                                            //     // If image dimensions are less than 410x292
                                            //     $style = 'width: 410px; height: 292px;';
                                            // } elseif ($width > 356 && $height > 254) {
                                            //     // If image dimensions are greater than 356x254 (for mobile)
                                            //     $style = 'width: 356px; height: 254px;';
                                            // }
                                            ?>
                                            <img src="{{ $imagePath }}" alt="" style="{{ $style }}">
                                        @else
                                            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="">
                                        @endif

                                        <a href="#"
                                            class="product-favorite">{{ ucfirst($favorite->favoritable->category->name) }}
                                            {{ $favorite->favoritable->operation->title }}</a>

                                    </div>
                                    <div class="product-content">
                                        <div class="product-top">
                                            <div class="product-category">
                                                <div class="product-category-icon">
                                                    <i class="far fa-heart"></i>
                                                </div>
                                                <h6 class="product-category-title"><a href="#"> @php
                                                    $userType = $favorite->favoritable->user->checkType();
                                                    $user_property_name = '';

                                                    switch ($userType) {
                                                        case 'company':
                                                            if ($favorite->favoritable->user->company) {
                                                                $user_property_name =
                                                                    $favorite->favoritable->user->company
                                                                        ->corporate_name;
                                                            } else {
                                                                // Handle the case where $favorite->favoritable->user->company is null
                                                                $user_property_name = ''; // Or any default value you want
                                                            }
                                                            break;

                                                        case 'particular':
                                                            if ($favorite->favoritable->user->particular) {
                                                                $user_property_name =
                                                                    $favorite->favoritable->user->particular
                                                                        ->first_name;
                                                                $last_name =
                                                                    $favorite->favoritable->user->particular->last_name;

                                                                if (!empty($last_name)) {
                                                                    $user_property_name .= ' ' . $last_name;
                                                                }
                                                            } else {
                                                                // Handle the case where $favorite->favoritable->user->company is null
                                                                $user_property_name = ''; // Or any default value you want
                                                            }

                                                            break;

                                                        default:
                                                            $user_property_name =
                                                                $favorite->favoritable->user->username;
                                                            break;
                                                    }
                                                @endphp
                                                        {{ ucfirst($user_property_name) }}</a></h6>
                                            </div>

                                        </div>
                                        <div class="product-info">

                                            <p style="
    margin-top: -12px;
    margin-left: -4px;
"><img
                                                    src="{{ asset('icon_png/location.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $favorite->favoritable->city->name }} ,
                                                {{ substr($favorite->favoritable->area->name, 0, 35) }}</p>
                                            @if ($favorite->favoritable->situation)
                                                @if ($favorite->favoritable->situation->slug === 'zone-urbaine')
                                                    <div class="product-date"
                                                        style="
    margin-top: -12px;
    margin-left: -4px;
">


                                                        <img src="{{ asset('icon_png/zone_urbain.png') }}" alt=""
                                                            style="width:55px;margin-left: -9px;">
                                                        {{ $favorite->favoritable->situation->name }}
                                                    </div>
                                                @elseif($favorite->favoritable->situation->slug === 'zone-industriel')
                                                    <div class="product-date"
                                                        style="
    margin-top: -12px;
    margin-left: -4px;
">
                                                        <img src="{{ asset('icon_png/zone_industri.png') }}" alt=""
                                                            style="width:55px;margin-left: -9px;">
                                                        {{ $favorite->favoritable->situation->name }}
                                                    </div>
                                                @else
                                                    <div class="product-date"
                                                        style="
    margin-top: -12px;
    margin-left: -4px;
">
                                                        <img src="{{ asset('icon_png/zone_rural.png') }}" alt=""
                                                            style="width:55px;margin-left: -9px;">
                                                        {{ $favorite->favoritable->situation->name }}
                                                    </div>
                                                @endif
                                            @endif


                                            <div class="product-date"
                                                style="
    margin-top: -12px;
    margin-left: -4px;
"><img
                                                    src="{{ asset('icon_png/m22.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;">
                                                {{ $favorite->favoritable->floor_area ?? $favorite->favoritable->surfacetotal }}
                                                m²</div>


                                            {{-- {{ dd($favorite->favoritable->operation->name) }} --}}

                                            <div class="product-date"
                                                style="
    margin-top: -12px;
    margin-left: -4px;
"><img
                                                    src="{{ asset('icon_png/calendar.png') }}" alt=""
                                                    style="width:55px;margin-left: -9px;"></i>
                                                {{ $favorite->favoritable->created_at }} </div>
                                        </div>
                                        <div class="product-bottom">
                                            <div class="product-price">
                                                @if ($favorite->favoritable->operation->name !== 'location')
                                                    {{ $favorite->favoritable->price }} DT
                                                @else
                                                    {{ $favorite->favoritable->price }} DT / Mois
                                                @endif

                                            </div>


                                            <a href="{{ route('prop_info', $favorite->favoritable->slug) }}"
                                                class="product-text-btn" style="font-size:12px">Voir
                                                Détails <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            @endif
                        </div>
                    @endforeach

                    {{-- {{ $props->links() }} --}}
                    {!! $favorites->appends(request()->query())->links('vendor.pagination.default') !!}
                @else
                    <p>Pas des annonces</p>
                @endif
            </div>
        </div>
    </div>
    {{-- <script>
        document.querySelectorAll('.delete-property').forEach(function(deleteButton) {
            deleteButton.addEventListener('click', function(event) {
                event.preventDefault();
                var confirmation = confirm('Are you sure you want to delete this property?');
                if (confirmation) {
                    var formId = this.dataset.formId;
                    document.getElementById('delete-property-form-' + {{ $favorite->favoritable->id }}).submit();
                }
            });
        });
    </script> --}}
@endsection
