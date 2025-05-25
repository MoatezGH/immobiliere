@switch(Route::current()->getName())
    @case('all_properties_promoteur')
        @include('includes.meta.direct_promoteur')
    @break

    @case('index_service_front')
        @include('includes.meta.service')
    @break

    @case('stores')
        @include('includes.meta.store')
    @break

    @default
    @include('includes.meta.default')
        

    @break
@endswitch
