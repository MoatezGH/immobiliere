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
    
    @case('all_properties')
        @include('includes.meta.property')
    @break

    @case('prop_info')
        @include('includes.meta.info_property')
    @break

@case('prop_info_promoteur')
        @include('includes.meta.info_property')
    @break
    
@case('index_classified_front')
        @include('includes.meta.classified')
    @break

@case('search.human')
        @include('includes.meta.property')
    @break


    @default
    @include('includes.meta.default')
        

    @break
@endswitch
