<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\General;
use App\Models\Admin\Social;
use App\Models\Admin\User;
use App\Models\Admin\Menu;
use App\Models\Admin\Header;
use App\Models\Admin\Footer;
use App\Models\Admin\Gdpr;
use App\Models\Admin\Advanced;
use App\Models\Admin\Advertisement;
use App\Models\Admin\Page;
use App\Models\Admin\FooterTranslation;
use App\Models\Admin\Sidebar;
use App\Models\Admin\Captcha;

class BlogController extends Controller
{

    public function index()
    {
        try {

            return view('frontend.blog', [
                'page'          => Page::where('type', 'home')->first(),
                'pageTrans'     => Page::withTranslation()->translatedIn( app()->getLocale() )->where('type', 'post')->where('post_status', true)->orderByTranslation('id', 'DESC')->paginate( General::first()->blog_page_count ),
                'siteTitle'     => env('APP_NAME'),
                'general'       => General::orderBy('id', 'DESC')->first(),
                'profile'       => User::with('user_socials')->orderBy('id', 'DESC')->first(),
                'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
                'header'        => Header::orderBy('id', 'DESC')->first(),
                'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
                'captcha'       => Captcha::orderBy('id', 'DESC')->first(),
                'notice'        => Gdpr::orderBy('id', 'DESC')->first(),
                'advanced'      => Advanced::orderBy('id', 'DESC')->first(),
                'advertisement' => Advertisement::orderBy('id', 'DESC')->first(),
                'socials'       => Social::orderBy('id', 'DESC')->get()->toArray(),
                'twitter'       => Social::where('name', 'twitter')->get('url')->first(),
                'sidebar'       => Sidebar::orderBy('id', 'DESC')->first(),
                'recent_posts'  => Page::withTranslation()->translatedIn( app()->getLocale() )->where('type', 'post')->where('post_status', true)->orderByTranslation('id', 'DESC')->get()->toArray(),
                'popular_tools' => Page::withTranslation()->translatedIn( app()->getLocale() )->where('type', 'tool')->where('popular', true)->where('tool_status', true)->orderByTranslation('id', 'DESC')->get()->toArray()
            ]);

        } catch (\Exception $e) {
            return redirect()->route('sw_install');
        }

    }

    public function store($slug){

        $page = Page::where('slug', $slug)->first();

        if( $page->type == 'post' ) {

            $pageTrans = Page::withTranslation()->translatedIn( app()->getLocale() )->whereTranslation('page_id', $page->id)->where('post_status', true)->first();

            if ( !empty($pageTrans) ) {

                 return view('frontend.pages', [
                    'page'          => $page,
                    'pageTrans'     => $pageTrans,
                    'pageTitle'     => !empty( $pageTrans->page_title ) ? $pageTrans->page_title : $pageTrans->title,
                    'siteTitle'     => env('APP_NAME'),
                    'general'       => General::orderBy('id', 'DESC')->first(),
                    'profile'       => User::with('user_socials')->where('is_admin', true)->orderBy('id', 'DESC')->first(),
                    'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
                    'header'        => Header::orderBy('id', 'DESC')->first(),
                    'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
                    'captcha'       => Captcha::orderBy('id', 'DESC')->first(),
                    'notice'        => Gdpr::orderBy('id', 'DESC')->first(),
                    'advanced'      => Advanced::orderBy('id', 'DESC')->first(),
                    'advertisement' => Advertisement::orderBy('id', 'DESC')->first(),
                    'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
                    'twitter'       => Social::where('name', 'twitter')->get('url')->first(),
                    'sidebar'       => Sidebar::orderBy('id', 'DESC')->first(),
                    'recent_posts'  => Page::withTranslation()->translatedIn( app()->getLocale() )->where('type', 'post')->where('post_status', true)->orderByTranslation('id', 'DESC')->get()->toArray(),
                    'popular_tools' => Page::withTranslation()->translatedIn( app()->getLocale() )->where('type', 'tool')->where('popular', true)->where('tool_status', true)->orderByTranslation('id', 'DESC')->get()->toArray()
                ]);

            } else return response()->view('errors.404', [
                'page'          => Page::where('type', 'home')->first(),
                'siteTitle'     => env('APP_NAME'),
                'general'       => General::orderBy('id', 'DESC')->first(),
                'profile'       => User::with('user_socials')->where('is_admin', true)->orderBy('id', 'DESC')->first(),
                'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
                'header'        => Header::orderBy('id', 'DESC')->first(),
                'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
                'captcha'       => Captcha::orderBy('id', 'DESC')->first(),
                'notice'        => Gdpr::orderBy('id', 'DESC')->first(),
                'advanced'      => Advanced::orderBy('id', 'DESC')->first(),
                'advertisement' => Advertisement::orderBy('id', 'DESC')->first(),
                'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
                'twitter'       => Social::where('name', 'twitter')->get('url')->first(),
            ], 404);
        
        } else return response()->view('errors.404', [
            'page'          => Page::where('type', 'home')->first(),
            'siteTitle'     => env('APP_NAME'),
            'general'       => General::orderBy('id', 'DESC')->first(),
            'profile'       => User::with('user_socials')->where('is_admin', true)->orderBy('id', 'DESC')->first(),
            'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
            'header'        => Header::orderBy('id', 'DESC')->first(),
            'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
            'captcha'       => Captcha::orderBy('id', 'DESC')->first(),
            'notice'        => Gdpr::orderBy('id', 'DESC')->first(),
            'advanced'      => Advanced::orderBy('id', 'DESC')->first(),
            'advertisement' => Advertisement::orderBy('id', 'DESC')->first(),
            'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
            'twitter'       => Social::where('name', 'twitter')->get('url')->first(),
        ], 404);

    }

}
