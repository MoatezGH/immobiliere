<td>
    <div class="table-ad-info">
        <a href="#">
            <img src="{{ asset($item->classified->mainPicture ? 'uploads/classified/main_picture/' . $item->classified->mainPicture->picture_path : 'assets/img/product/01.jpg') }}"
                                                        alt="" style="height: 60px;">

            


            <div class="table-ad-content">
                <h6>{{ ucfirst(substr($item->classified->title, 0, 50)) }}</h6>


                <span style="font-size: 10px;">
                    <small>

                        {{ $item->classified->created_at }} / Ref: {{ $item->classified->ref }}
                    </small>
                    


                </span>

            </div>
        </a>
    </div>
</td>
<td> {{ $item->classified->user->full_name }}
</td>
<td>{{ ucfirst($item->classified->category->name) }}</td>

<td>{{ $item->classified->count_views }}</td>

<td>
    
    <a href="{{ route('classifieds.admin.info', $item->classified->id) }}" target="__blank"
        class="btn btn-outline-secondary btn-sm rounded-2" data-bs-toggle="tooltip"
        aria-label="detail" data-bs-original-title="detail"><i
            class="far fa-eye"></i></a>

            

    <a href="#"
        class="btn btn-outline-danger btn-sm rounded-2 delete-property"
        data-bs-toggle="tooltip" aria-label="Delete"
        onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce annonce premium?')) { document.getElementById('property-features-destroy-{{ $item->id }}').submit(); }"
        data-bs-original-title="supprimer"><i class="far fa-trash-can"></i></a>

    <form display="none" id="property-features-destroy-{{ $item->id }}"
        action="{{ route('admin.property-features.destroy', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')

    </form>

</td>