<?php

namespace App\Console\Commands;

use App\Models\Admin\Page;
use App\Models\Admin\PageTranslation;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CrawlBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl-blogs';

    /**
     * The console Crawl Blogs.
     *
     * @var string
     */
    protected $description = 'Crawl Blogs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $menus = ['seo', 'paid-media', 'content', 'social', 'digital'];
        try {
            foreach ($menus as $menu) {
                // $crawler = $client->request('GET', 'https://www.searchenginejournal.com/category/' . $menu);
                // $lastPage = $crawler->filter('ul.page-numbers li:nth-child(5) a')->text();
                // $i = ceil(((int) $lastPage) / 4);
                $i = 20;
                while ($i > -1) {
                    $crawler = $client->request('GET', 'https://www.searchenginejournal.com/category/' . $menu . '/page/' . $i);
                    $crawler->filter('#archives-wrapper article')->each(function ($article) use ($client) {
                        $url = $article->filter('a.title-anchor')->attr('href');
                        // echo $url;
                        $crawler = $client->request('GET', $url);

                        // Title
                        $h1 = $crawler->filter('#main-content .sej-stitle.entry-title')->text();
                        $title = $this->paraphrase($h1);

                        // Slug
                        $slug = Str::slug($title);

                        // // Featured Image
                        $thumbSrc = $crawler->filter('figure.sej-sthumb picture img')->attr('src');
                        if (!empty($thumbSrc)) {
                            $buffer = file_get_contents($thumbSrc);
                            $featuredImage = '/public/photos/1/blog/' . $slug . '/thumb/thumb.png';
                            Storage::put($featuredImage, $buffer);
                        }

                        $page = Page::where('slug', $slug)->first();
                        if (empty($page->id)) {
                            $page = Page::create([
                                'slug' => $slug,
                                'type' => 'post',
                                'featured_image' => '/components/storage/app' . $featuredImage
                            ]);

                            // Page Title
                            $pageTitle = "[BLOG] " . $title;

                            // // Sub Title
                            $subTitle = $crawler->filter('#main-content .cintro')->count() > 0 ? $crawler->filter('#main-content .cintro')->text() : $title;

                            // Description
                            $description = "";
                            $html = $crawler->filter('.sej-article-content #narrow-cont')->html();
                            $htmlTags = explode("\n", $html);
                            foreach ($htmlTags as $tag) {
                                if (str_contains($tag, "<div")) {
                                    continue;
                                } else if (str_contains($tag, "<iframe")) {
                                    preg_match('/ src="([^"]*)"/', $tag, $result1);
                                    if (empty($result1)) {
                                        preg_match('/ data-src="([^"]*)"/', $tag, $result2);
                                        $tag = '<iframe title="' . $title . '" style="width:100%;min-height:450px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" src="' . $result2[1] . '" class="b-lazy"></iframe>';
                                    }
                                    $description .= $tag;
                                } else if (str_contains($tag, "<img")) {
                                    preg_match('/ data-src="([^"]*)"/', $tag, $imageSrcs);
                                    $imageSrc = $imageSrcs[1];
                                    echo $imageSrc . "\n";
                                    if (!empty($imageSrc) && !str_contains($imageSrc, 'data:image/')) {
                                        $buffer = file_get_contents($imageSrc);
                                        $image = '/public/photos/1/blog/' . $slug . '/images/seo-' . rand(10000, 99999) . '.png';
                                        Storage::put($image, $buffer);
                                        $description .= "<div class='w-100'><img src='/components/storage/app" . $image . "' /></div>";
                                    }
                                } else if (str_contains($tag, "<ul")) {
                                    $ul = "<ul>";
                                    preg_match_all("'<li>(.*?)</li>'si", $tag, $lis);
                                    foreach ($lis[1] as $li) {
                                        $ul .= "<li>" . $this->paraphrase($li) . "</li>";
                                    }
                                    $ul .= "</ul>";
                                    $description .= $ul;
                                } else if (str_contains($tag, "<h4") || str_contains($tag, "<h3") || str_contains($tag, "<h2") || str_contains($tag, "<p")) {
                                    $text = strip_tags($tag);
                                    $aiText = $this->paraphrase($text);
                                    $replaced = str_replace($text, $aiText, $tag);
                                    $description .= $replaced;
                                }
                            }

                            $translation = PageTranslation::where('page_id', $page->id)->first();
                            if (empty($translation->id)) {
                                $translation = PageTranslation::create([
                                    'locale' => 'en',
                                    'page_title' => $pageTitle,
                                    'title' => $title,
                                    'subtitle' => $subTitle,
                                    'short_description' => $subTitle,
                                    'description' => $description,
                                    'page_id' => $page->id
                                ]);
                            }

                            echo $translation->title . "\n";
                        }

                        // die;
                    });
                    $i = --$i;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return 0;
    }

    protected function paraphrase($text)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://paraphraser.prod.hipcv.com/paraphrase");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "text" => $text,
            "mode" => "fluent"
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);
        $server_output = json_decode($server_output);
        if (isset($server_output->data)) {
            return implode(" ", $server_output->data);
        }
        return '';
    }
}
