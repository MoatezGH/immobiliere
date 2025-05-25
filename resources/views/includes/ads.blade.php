<br>
                    <h5 class="title">PUBLICITÉS</h5>
                    <br>
                    <div class="blog-item-img" style="overflow:auto">
                        @foreach ($ads as $ad)
                            <a href="{{ $ad->url ? route('ad.click', ['id' => $ad->id]) : '#' }}" class="mb-4"
                                title="{{ ucfirst($ad->description) }}">
                                <img src="{{ asset($ad ? 'uploads/ads/' . $ad->alt : 'assets/img/account/user0.jpg') }} "
                                    alt="{{ ucfirst($ad->description) }}">
                            </a>
                        @endforeach
                    </div>