<?php
namespace Regex\Redirect;

class RegexRedirect {
    
    const REDIRECT_CODE = 301;
    const REDIRECT_RGX = [
        '/^\/actualidad\/([\w-]+)\?c=([a-z]+)$/' => '/$2/blog/$1',
        '/^\/proyectos\?c=([a-z]+)$/' => '/$1/proyectos/',
        '/^\/proyecto\/([\w-]+)\?c=([a-z]+)$/' => '/$2/proyecto/$1',
        "/^\/(?#cat)(?!proyecto|noticia)[\w-]+(?#sub-cat)(?:\/[a-z-]+)*(?#\/)\/(?#product)([\w-]+)(?#lang)\?c=([\w]+)$/" => '/producto/$1'
    ];

    private $uri;
    private $redirectUri;

    public static function redirect() {
        new RegexRedirect($_SERVER['REQUEST_URI']);
    }

    private function __construct($uri) {

        $this->uri = $uri;
        if ($this->replaceRgx()){
            $this->makeRedirect();
        }
            
    }

    private function replaceRgx() {

        foreach (self::REDIRECT_RGX as $rgx => $rgxReplace) {
            if (preg_match($rgx, $this->uri)) {
                $this->redirectUri = preg_replace($rgx, $rgxReplace, $this->uri);
                return true;
            }
        }
        return false;

    }

    private function makeRedirect() {
        wp_redirect(get_site_url(null, $this->redirectUri), self::REDIRECT_CODE);
        die();
    }

}