<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "https://google.com/article"
    },
    "headline": "{{$data->name}}"@if(!empty(Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name)),
    "image": [
      "{{ url('/images/') }}/{{ Cmf::get_image_name('blogimages' , 'blogid' , $data->id)->first()->image_name }}"
    ]@endif,
    "datePublished": "{{ date('Y-m-d', strtotime($data->created_at)) }}T{{ date('H:s', strtotime($data->created_at)) }}",
    "dateModified": "{{ date('Y-m-d', strtotime($data->created_at)) }}T{{ date('H:s', strtotime($data->created_at)) }}",
    "author": {
      "@type": "Person",
      "name": "@if(!empty(DB::table('users')->where('id' , $data->added_by)->get()->first())){{ DB::table('users')->where('id' , $data->added_by)->get()->first()->name }} @else Answerout @endif"
    },
    "publisher": {
      "@type": "Organization",
      "name": "AnswerOut",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ url('front/assets/images/fav.png') }}"
      }
    }
  }
  </script>
