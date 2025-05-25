<div class="product-item">
    <div class="product-img">
        <span style="font-size:10px" class="product-status featured">{{ strtoupper($item->ref) }}</span>
        <a href="{{ route('classified_info_front', $item->slug) }}">
        {{-- @if ($item->main_picture) --}}
        @if (!empty($item->mainPicture->picture_path) &&
                file_exists(public_path('uploads/classified/main_picture/' . $item->mainPicture->picture_path)))
            <?php
            $imagePath = asset('uploads/classified/main_picture/' . $item->mainPicture->picture_path);
            [$width, $height] = getimagesize(public_path('uploads/classified/main_picture/' . $item->mainPicture->picture_path));
            
            $style = $width < 410 && $height < 292 ? 'width: 410px; height: 292px;' : '';
            ?>
            <img src="{{ $imagePath }}" alt="" style="{{ $style }}">
        @else
            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="">
        @endif
    </a>
        <a style="font-size:10px" href="#" class="product-favorite">{{ ucfirst($item->category->name) }}
            </a>

    </div>
    <div class="product-content">
        <div class="product-top">
            <div class="product-category">
                <div class="product-category-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h6 class="product-category-title"><a href="#">
                        
                        
                        {{-- {{ ucfirst($item->user->full_name) }} --}}
                        {{ ucfirst($item->title) }}

                        {{-- hello hello hello --}}
                    </a></h6>
            </div>

        </div>
        <div class="product-info">

            


            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
            </div>


            {{-- {{ dd($item->operation->name) }} --}}

            <div class="product-date"
                style="
                        margin-top: -12px;
                        margin-left: -4px;
                    ">
                <img src="{{ asset('icon_png/calendar.png') }}" alt=""
                    style="width:55px;margin-left: -9px;"></i>
                    {{$item->created_at->format('d/m/y')  }}
            </div>
        </div>
        <div class="product-bottom">
            <div class="product-price">
                
                    {{ $item->price }} DT
                

            </div>


            <a href="{{ route('classified_info_front', $item->slug) }}" class="product-text-btn" style="font-size:12px">Voir
                Détails <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
{{-- </div> --}}
