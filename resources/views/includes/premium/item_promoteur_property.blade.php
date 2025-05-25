<div class="product-item">
    <div class="product-img">
        <span class="product-status featured">{{ strtoupper($item->propertypromoteur->ref) }}</span>
        <a href="{{ route('prop_info_promoteur', $item->propertypromoteur->slug) }}">

        @if ($item->propertypromoteur->getFirstImageOrDefault())
            <img src="{{ asset('uploads/promoteur_property/' . $item->propertypromoteur->getFirstImageOrDefault()) }}" alt="{{ $item->propertypromoteur->title }}">
        @else
            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="{{ $item->propertypromoteur->title }}">
        @endif
        <a href="#" class="product-favorite">{{ ucfirst($item->propertypromoteur->category->name) }}
            {{ $item->propertypromoteur->operation->title }}</a>
        </a>
    </div>
    <div class="product-content">
        <div class="product-top">
            <div class="product-category">
                <div class="product-category-icon">
                    <i class="far fa-heart" ></i>
                </div>
                <h6 class="product-category-title"><a
                        href="#">{{ ucfirst($item->propertypromoteur->user->promoteur->first_name . ' ' . $item->propertypromoteur->user->promoteur->last_name) }}
                    </a></h6>
            </div>
            {{-- <div class="product-rate">
                                            <i class="fas fa-star"></i>
                                            <span>4.5</span>
                                        </div> --}}
        </div>
        <div class="product-info">
            {{-- <h5><a href="#">{{ $item->propertypromoteur->title }}</a></h5> --}}
            <p style="
    margin-top: -12px;
    margin-left: -4px;
"><img src="{{ asset('icon_png/location.png') }}"
                    alt="{{ $item->propertypromoteur->city->name }} ,
                {{ $item->propertypromoteur->area->name }}" style="width:55px;margin-left: -9px;">
                {{ $item->propertypromoteur->city->name }} ,
                {{ $item->propertypromoteur->area->name }}</p>


            <div class="product-date" style="
    margin-top: -12px;
    margin-left: -4px;
"><img src="{{ asset('icon_png/m22.png') }}" alt="m²"
                    style="width:55px;margin-left: -9px;">
                {{ $item->propertypromoteur->surface_totale }} (m²)</div>


            <div class="product-date" style="
    margin-top: -12px;
    margin-left: -4px;
"> <img src="{{ asset('icon_png/calendar.png') }}" alt="date"
                    style="width:55px;margin-left: -9px;">
                {{ $item->propertypromoteur->created_at }}</div>
        </div>
        <div class="product-bottom">
            <div class="product-price">

                {{ $item->propertypromoteur->price_total }} DT


            </div>

            <a href="{{ route('prop_info_promoteur', $item->propertypromoteur->slug) }}" class="product-text-btn" style="font-size:12px">Voir Détails <i
                    class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
