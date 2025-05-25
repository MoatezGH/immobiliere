{{-- <div class="col-md-6 "> --}}
<div class="product-item">
    <div class="product-img">
        <span class="product-status featured">{{ strtoupper($item->property->ref) }}</span>
        <a href="{{ route('prop_info', $item->property->slug) }}">
        {{-- @if ($item->property->main_picture) --}}
        @if (isset($item->property->main_picture) &&
                isset($item->property->main_picture) &&
                isset($item->property->main_picture->alt) &&
                file_exists(public_path('uploads/main_picture/images/properties/' . $item->property->main_picture->alt)))
            <?php
            $imagePath = asset('uploads/main_picture/images/properties/' . $item->property->main_picture->alt);
            [$width, $height] = getimagesize(public_path('uploads/main_picture/images/properties/' . $item->property->main_picture->alt));
            
            $style = $width < 410 && $height < 292 ? 'width: 410px; height: 292px;' : '';
            
            ?>
            <img src="{{ $imagePath }}" alt="{{ $item->property->title }}" style="{{ $style }}">
        @else
            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="{{ $item->property->title }}">
        @endif
    </a>
        <a href="#" class="product-favorite">{{ ucfirst($item->property->category->name) }}
            {{ $item->property->operation->title }}</a>

    </div>
    <div class="product-content">
        <div class="product-top">
            <div class="product-category">
                <div class="product-category-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h6 class="product-category-title"><a href="#">
                        {{-- @php
                            $userType = $item->property->user->checkType();
                            $user_property_name = '';

                            switch ($userType) {
                                case 'company':
                                    if ($item->property->user->company) {
                                        $user_property_name = $item->property->user->company->corporate_name;
                                    } else {
                                        $user_property_name = '';
                                    }
                                    break;

                                case 'particular':
                                    if ($item->property->user->particular) {
                                        $user_property_name = $item->property->user->particular->first_name;
                                        $last_name = $item->property->user->particular->last_name;

                                        if (!empty($last_name)) {
                                            $user_property_name .= ' ' . $last_name;
                                        }
                                    } else {
                                        $user_property_name = '';
                                    }

                                    break;

                                default:
                                    $user_property_name = $item->property->user->username;
                                    break;
                            }
                        @endphp --}}
                        @php
                            $userType = $item->property->user->checkType();
                            //  dd($item->property->user->particular);
                            $user_property_name = '';

                            switch ($userType) {
                                case 'company':
                                    if (isset($item->property->user->company)) {
                                        $user_property_name = $item->property->user->company->corporate_name;
                                    } else {
                                        $user_property_name = '';
                                    }
                                    break;

                                case 'particular':
                                    if (isset($item->property->user->particular)) {
                                        $user_property_name = $item->property->user->particular->first_name;

                                        $last_name = '';

                                        if (!empty($last_name)) {
                                            // die('no');
                                            $last_name = $item->property->user->particular->last_name;
                                            $user_property_name .= ' ' . $last_name;
                                        }
                                    } else {
                                        $user_property_name = '';
                                    }
                                    break;

                                default:
                                    $user_property_name = $item->property->user->username;
                                    break;
                            }

                        @endphp
                        {{ ucfirst($user_property_name) }}
                        {{-- hello hello hello --}}
                    </a></h6>
            </div>

        </div>
        <div class="product-info">

            <p
                style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">
                <img src="{{ asset('icon_png/location.png') }}" alt="{{ $item->property->city->name }} ,
                {{ $item->property->area->name }}" style="width:55px;margin-left: -9px;">
                {{ $item->property->city->name }} ,
                {{ substr($item->property->area->name, 0, 35) }}
            </p>
            @if ($item->property->situation)
                @if ($item->property->situation->slug === 'zone-urbaine')
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">


                        <img src="{{ asset('icon_png/zone_urbain.png') }}" alt="{{ $item->property->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->property->situation->name }}
                    </div>
                @elseif($item->property->situation->slug === 'zone-industriel')
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">
                        <img src="{{ asset('icon_png/zone_industri.png') }}" alt="{{ $item->property->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->property->situation->name }}
                    </div>
                @else
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">
                        <img src="{{ asset('icon_png/zone_rural.png') }}" alt="{{ $item->property->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->property->situation->name }}
                    </div>
                @endif
            @endif


            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
                <img src="{{ asset('icon_png/m22.png') }}" alt="m²" style="width:55px;margin-left: -9px;">
                {{ $item->property->floor_area ?? $item->property->surfacetotal }} (m²)
            </div>


            {{-- {{ dd($item->property->operation->name) }} --}}

            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
                <img src="{{ asset('icon_png/calendar.png') }}" alt="date"
                    style="width:55px;margin-left: -9px;"></i>
                {{ $item->property->created_at }}
            </div>
        </div>
        <div class="product-bottom">
            <div class="product-price">
                @if ($item->property->operation->name !== 'location')
                    {{ $item->property->price }} DT
                @else
                    {{ $item->property->price }} DT / Mois
                @endif

            </div>


            <a href="{{ route('prop_info', $item->property->slug) }}" class="product-text-btn" style="font-size:12px">Voir
                Détails <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
{{-- </div> --}}
