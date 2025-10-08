<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{env('APP_NAME')}} ]]></title>
        <link><![CDATA[ {{env('FRONT_URL').'/feed'}} ]]></link>
        <description><![CDATA[ {{env('APP_NAME')}} ]]></description>
        <language>{{config('app.locale')}}</language>
        <pubDate>{{ now() }}</pubDate>
        @foreach($products as $product)
                    <item>
                        <title><![CDATA[{{ $product->title}}]]></title>
                        <link> {{route('product.show',$product->slug)}} </link>
                        <description><![CDATA[{!! $product->description !!}]]></description>
                        <category>{{$product->category->name}}</category>
                        <author><![CDATA[{{$product->user->full_name}}]]></author>
                        <image>
                            <url>
                                @if($product->photo_id)
                                    {{$product->photo->address}}
                                @else
                                    {{$product->title}}
                                @endif
                            </url>
                            <title>{{$product->title}}</title>
                            <link>{{route('product.show',$product->slug)}}</link>
                        </image>
                        <guid>{{$product->id}}</guid>
                        <pubDate>{{$product->updated_at}}</pubDate>
                    </item>
                @endforeach
        @foreach($categories as $category)
                    <item>
                        <title><![CDATA[{{ $category->name}}]]></title>
                        <link> {{route('category.show',$category->slug)}} </link>
                        <description><![CDATA[{!! $category->description !!}]]></description>
                        <category>{{$category->name}}</category>
                        <image>
                            <url>
                                @if($category->photo_id)
                                    {{$category->photo->address}}
                                @else
                                    {{$category->name}}
                               @endif
                            </url>
                            <title>{{$category->name}}</title>
                            <link>{{route('category.show',$category->slug)}}</link>
                        </image>
                        <guid>{{$category->id}}</guid>
                        <pubDate>{{$category->updated_at}}</pubDate>
                    </item>
                @endforeach
        @foreach($articles as $article)
                    <item>
                        <title><![CDATA[{{ $article->title}}]]></title>
                        <link> {{route('article.show',$article->slug)}} </link>
                        <description><![CDATA[{!! $article->description !!}]]></description>
                        <author><![CDATA[{{$article->user->full_name}}]]></author>
                        <image>
                            <url>
                                @if($article->photo_id)
                                    {{$article->photo->address}}
                                @else
                                    {{$article->name}}
                                @endif
                            </url>
                            <title>{{$article->title}}</title>
                            <link>{{route('article.show',$article->slug)}}</link>
                        </image>
                        <guid>{{$article->id}}</guid>
                        <pubDate>{{$article->updated_at}}</pubDate>
                    </item>
                @endforeach
    </channel>
</rss>
