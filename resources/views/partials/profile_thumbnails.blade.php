@if ($thumbnails->isNotEmpty())
    @foreach ($thumbnails as $thumbnail)
        <img src="{{ Storage::url($thumbnail->url) }}" class="thumbnail-item cursor-pointer" alt="Profile image">
    @endforeach
@else
    <p>No profile thumbnails available.</p>
@endif