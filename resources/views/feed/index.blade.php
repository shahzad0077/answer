<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ Answer Out - Answer For Your Query | Certification Answers ]]></title>
        <link><![CDATA[ {{url('feed-new-rss.xml')}} ]]></link>
        <description><![CDATA[ Answer Out is run by a Passionate Team. We&#039;re Teamed Up with the Best in Knowledge Personals. Here are the experts in Digital Marketing and other topics regarding Search Engines, Growing and Budding Industries. Feel Free to Comment and Ask Questions. Enjoy your time with Answerout.com We&#039;re Always Open for Contribution and Credits. ]]></description>
        <language>en</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->name }}]]></title>
                <link>{{ url('') }}/{{ $post->slug }}</link>
                <description><![CDATA[{!! $post->blog !!}]]></description>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach

        @foreach(DB::table('answerquestions')->where('delete_status' , 'Active')->where('visible_status' , 'Published')->orderby('id' , 'desc')->limit(200)->get() as $post)
            <item>
                <title><![CDATA[{{ $post->question_name }}]]></title>
                <link>{{ url('question') }}/{{ $post->question_url }}</link>
                <description><![CDATA[{!! $post->question_content !!}]]></description>
                <category>{{ $post->question_subject }}</category>
                <author><![CDATA[{{ $post->question_auther   }}]]></author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>