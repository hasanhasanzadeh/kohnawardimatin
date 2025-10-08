<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">


        @foreach ($products as $product)
            <url>

                <loc>{{url("/product/show/$product->slug")}}</loc>

                <lastmod>{{$product->updated_at}}</lastmod>

                <changefreq>daily</changefreq>

                <priority>0.8</priority>

            </url>
        @endforeach

        @foreach ($categories as $category)
                <url>

                    <loc>{{route('category.show',$category->slug)}}</loc>

                    <lastmod>{{$category->created_at}}</lastmod>

                    <changefreq>daily</changefreq>

                    <priority>0.8</priority>

                </url>
            @endforeach

        @foreach ($articles as $article)
                <url>

                    <loc>{{route('article.show',$article->slug)}}</loc>

                    <lastmod>{{$article->created_at}}</lastmod>

                    <changefreq>daily</changefreq>

                    <priority>0.8</priority>

                </url>
            @endforeach

</urlset>
