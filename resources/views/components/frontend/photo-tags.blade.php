@if(!empty($photoTags))
    <div class="photo_page__tags">
        @foreach($photoTags as $nexPhotoTag)
        <a href="#" class="photo_page__tags-item">
            #{{$nexPhotoTag->tag->title}}
        </a>
        @endforeach
    </div>
@endif
