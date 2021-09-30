@extends('layouts.app')

@section('content')
  <div class="bg-white p-3 post-card">
    @if ($post->hasThumbnail())
      {{ Html::image($post->thumbnail->getUrl(), $post->thumbnail->name, ['class' => 'card-img-top']) }}
    @endif

    <h1 v-pre>{{ $post->title }}</h1>

    <div class="mb-3">
      <small v-pre class="text-muted">{{ link_to_route('users.show', $post->author->fullname, $post->author) }}</small>,
      <small class="text-muted">{{ humanize_date($post->posted_at) }}</small>
    </div>
    <div id="content-regulars" content="{{ $post->content }}" style="display: none">
    </div>
    <!-- render with trumbowyg-editor -->
    <div v-pre id="post-content-trumbowyg-editor">
      {!! $post->content !!}
    </div>

    <!-- render with markdown (viblo sdk) -->
    <div v-pre id="post-content">
    </div>

    <p class="mt-3">
      <like
        :likes-count="{{ $post->likes_count }}"
        :liked="{{ json_encode($post->isLiked()) }}"
        :item-id="{{ $post->id }}"
        item-type="posts"
        :logged-in="{{ json_encode(Auth::check()) }}"
      />
    </p>
  </div>

  @include ('comments/_list')
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.18/dist/katex.min.css" integrity="sha384-zTROYFVGOfTw7JV7KUu8udsvW2fx4lWOsCEDqhBreBwlHI4ioVRtmIvEThzJHGET" crossorigin="anonymous">

<script type="module">
  $(document).ready(function() {
    const content = $('#content-regulars').attr('content')
    console.log(md.render(content))
    $('#post-content').html(md.render(content))
  })
</script>