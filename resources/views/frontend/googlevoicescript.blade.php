<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "QAPage",
  "mainEntity": {
    "@type": "Question",
    "name": "{{$data->question_name}}",
    "text": "{{$data->question_content}}",
    "answerCount": {{ $answers->count() }},
    "upvoteCount": {{$data->question_like}},
    "dateCreated": "{{ date('Y-m-d', strtotime($data->created_at)) }}T{{ date('H:s', strtotime($data->created_at)) }}Z",
    "author": {
      "@type": "Person",
      "name": "{{$data->question_auther}}"
    }@if($answers->count() > 0),
    "acceptedAnswer": {
      "@type": "Answer",
      "text": "{!! strip_tags($answers->first()->answer) !!}",
      "dateCreated": "{{ date('Y-m-d', strtotime($answers->first()->created_at)) }}T{{ date('H:s', strtotime($answers->first()->created_at)) }}Z",
      "upvoteCount":@if(!empty($answers->first()->likes)){{$answers->first()->likes}}@else 1 @endif,
      "url": "{{url('question')}}/{{ $data->question_url }}#{{ $answers->first()->id }}",
      "author": {
        "@type": "Person",
        "name": "{{$answers->first()->users}}"
      }
    }@if($answers->count() > 1),
    "suggestedAnswer": [
    @foreach($answers as $r)
      {
        "@type": "Answer",
        "text": "{!! strip_tags($r->answer) !!}",
        "dateCreated": "{{ date('Y-m-d', strtotime($r->created_at)) }}T{{ date('H:s', strtotime($r->created_at)) }}Z",
        "upvoteCount": @if(!empty($r->likes)){{$r->likes}}@else 1 @endif,
        "url": "{{url('question')}}/{{ $data->question_url }}#{{ $r->id }}",
        "author": {
          "@type": "Person",
          "name": "{{$r->users}}"
        }
      }@if($loop->last)
       @else
       ,
       @endif
     @endforeach 
    ]
    @endif
    @endif
  }
}
</script>