{{-- <div class="col-md-6 "> --}}
<div class="product-item">
    <div class="product-img">
        <span class="product-status featured">{{ strtoupper($item->ref) }}</span>
        <a href="{{ route('prop_info', $item->slug) }}">
        {{-- @if ($item->main_picture) --}}
        @if (isset($item->main_picture) &&
                isset($item->main_picture) &&
                isset($item->main_picture->alt) &&
                file_exists(public_path('uploads/main_picture/images/properties/' . $item->main_picture->alt)))
            <?php
            $imagePath = asset('uploads/main_picture/images/properties/' . $item->main_picture->alt);
            [$width, $height] = getimagesize(public_path('uploads/main_picture/images/properties/' . $item->main_picture->alt));
            
            $style = $width < 410 && $height < 292 ? 'width: 410px; height: 292px;' : '';
            
            ?>
            <img src="{{ $imagePath }}" alt="{{ $item->title }}" style="{{ $style }}">
        @else
            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="{{ $item->title }}">
        @endif
    </a>
        <a href="#" class="product-favorite">{{ ucfirst($item->category->name) }}
            {{ $item->operation->title }}</a>

    </div>
    <div class="product-content">
        <div class="product-top">
            <div class="product-category">
                <div class="product-category-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h6 class="product-category-title"><a href="#">
                        
                        @php
                            $userType = $item->user->checkType();
                            //  dd($item->user->particular);
                            $user_property_name = '';

                            switch ($userType) {
                                case 'company':
                                    if (isset($item->user->company)) {
                                        $user_property_name = $item->user->company->corporate_name;
                                    } else {
                                        $user_property_name = '';
                                    }
                                    break;

                                case 'particular':
                                    if (isset($item->user->particular)) {
                                        $user_property_name = $item->user->particular->first_name;

                                        $last_name = '';

                                        if (!empty($last_name)) {
                                            // die('no');
                                            $last_name = $item->user->particular->last_name;
                                            $user_property_name .= ' ' . $last_name;
                                        }
                                    } else {
                                        $user_property_name = '';
                                    }
                                    break;

                                default:
                                    $user_property_name = $item->user->username;
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
                <img src="{{ asset('icon_png/location.png') }}" alt="{{ $item->city->name }} ,
                {{ substr($item->area->name, 0, 35) }}" style="width:55px;margin-left: -9px;">
                {{ $item->city->name }} ,
                {{ substr($item->area->name, 0, 35) }}
            </p>
            @if ($item->situation)
                @if ($item->situation->slug === 'zone-urbaine')
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">


                        <img src="{{ asset('icon_png/zone_urbain.png') }}" alt="{{ $item->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->situation->name }}
                    </div>
                @elseif($item->situation->slug === 'zone-industriel')
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">
                        <img src="{{ asset('icon_png/zone_industri.png') }}" alt="{{ $item->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->situation->name }}
                    </div>
                @else
                    <div class="product-date"
                        style="
                                margin-top: -12px;
                                margin-left: -4px;
                            ">
                        <img src="{{ asset('icon_png/zone_rural.png') }}" alt="{{ $item->situation->name }}"
                            style="width:55px;margin-left: -9px;">
                        {{ $item->situation->name }}
                    </div>
                @endif
            @endif


            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
                <img src="{{ asset('icon_png/m22.png') }}" alt="m²" style="width:55px;margin-left: -9px;">
                {{ $item->floor_area ?? $item->surfacetotal }} (m²)
            </div>


            {{-- {{ dd($item->operation->name) }} --}}

            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
                <img src="{{ asset('icon_png/calendar.png') }}" alt="date"
                    style="width:55px;margin-left: -9px;"></i>
                {{ $item->created_at }}
            </div>
        </div>
        <div class="product-bottom">
            <div class="product-price">
                @if ($item->operation->name !== 'location')
                    {{ $item->price }} DT
                @else
                    {{ $item->price }} DT / Mois
                @endif

            </div>


            <a href="{{ route('prop_info', $item->slug) }}" class="product-text-btn" style="font-size:12px">Voir
                Détails <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
{{-- </div> --}}
