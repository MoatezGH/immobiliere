
{{-- {{ dd(!empty($item->classified->mainPicture->picture_path)) }} --}}
<div class="product-item">
    <div class="product-img">
        <span style="font-size:10px" class="product-status featured">{{ strtoupper($item->classified->ref) }}</span>
        <a href="{{ route('classified_info_front', $item->classified->slug) }}">
        {{-- @if ($item->main_picture) --}}
        @if (!empty($item->classified->mainPicture->picture_path) &&
                file_exists(public_path('uploads/classified/main_picture/' . $item->classified->mainPicture->picture_path)))
            <?php
            $imagePath = asset('uploads/classified/main_picture/' . $item->classified->mainPicture->picture_path);
            [$width, $height] = getimagesize(public_path('uploads/classified/main_picture/' . $item->classified->mainPicture->picture_path));
            
            $style = $width < 410 && $height < 292 ? 'width: 410px; height: 292px;' : '';
            
            ?>


            <img src="{{ $imagePath }}" alt="" style="{{ $style }}">
        @else
            <img src="{{ asset('assets/img/product/01.jpg') }}" alt="">
        @endif
    </a>
        <a style="font-size:10px" href="#" class="product-favorite">{{ ucfirst($item->classified->category->name) }}
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
                        {{ ucfirst($item->classified->title) }}

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
                    {{$item->classified->created_at->format('d/m/y')  }}
            </div>
        </div>
        <div class="product-bottom">
            <div class="product-price">
                
                    {{ $item->classified->price }} DT
                

            </div>


            <a href="{{ route('classified_info_front', $item->classified->slug) }}" class="product-text-btn" style="font-size:12px">Voir
                Détails <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
{{-- </div> --}}
