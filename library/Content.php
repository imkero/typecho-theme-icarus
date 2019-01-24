<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Content
{
    public static function getContent($post)
    {
        // todo: process tag in content
        // dummy
        return $post->content;
    }

    public static function getExcerpt($post)
    {
        // todo: (option) preserve style in excerpt
        
        // todo: (option) excerpt length & tail;
        $length = 100;
        $tail = '...';

        // todo: remove special tag
        
        return Typecho_Common::subStr(strip_tags($post->excerpt), 0, $length, $tail);
    }
}