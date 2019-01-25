<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Content
{
    /**
     * Retrieve the shortcode regular expression for searching.
     *
     * The regular expression combines the shortcode tags in the regular expression
     * in a regex class.
     *
     * 1 - An extra [ to allow for escaping shortcodes with double [[]]
     * 2 - The shortcode name
     * 3 - The shortcode argument list
     * 4 - The self closing /
     * 5 - The content of a shortcode when it wraps some content.
     * 6 - An extra ] to allow for escaping shortcodes with double [[]]
     *
     *
     * @param array $tagnames Optional. List of shortcodes to find. Defaults to all registered shortcodes.
     * @return string The shortcode search regular expression
     * 
     * @link https://github.com/WordPress/WordPress/blob/70bc51e46f18a15b2abf9161aa82635f059beb82/wp-includes/shortcodes.php#L230
     */
    private static function getShortcodeRegex( $tagnames = null ) {
        global $shortcode_tags;
        if ( empty( $tagnames ) ) {
            $tagnames = array_keys( $shortcode_tags );
        }
        $tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            .     '(?:'
            .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
            .     ')*?'
            . ')'
            . '(?:'
            .     '(\\/)'                        // 4: Self closing tag ...
            .     '\\]'                          // ... and closing bracket
            . '|'
            .     '\\]'                          // Closing bracket
            .     '(?:'
            .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            .             '[^\\[]*+'             // Not an opening bracket
            .             '(?:'
            .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            .                 '[^\\[]*+'         // Not an opening bracket
            .             ')*+'
            .         ')'
            .         '\\[\\/\\2\\]'             // Closing shortcode tag
            .     ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }

    private static function processGalleryCallback($matches)
    {
        // escaping [[tagName]]
        if ( $matches[1] == '[' && $matches[6] == ']' ) {
            return substr($matches[0], 1, -1);
        }

        return '<div class="justified-gallery">' . $matches[5] . '</div>';
    }

    private static function processTag($content, $tagName, $callbackFuncName)
    {
        if (strpos($content, '[' . $tagName) !== FALSE){
            $pattern = self::getShortcodeRegex(array($tagName));
            $content = preg_replace_callback(
                "/$pattern/", array(__CLASS__, $callbackFuncName),
                $content
            );
        }
        return $content;
    }

    public static function getContent($post)
    {
        $content = $post->content;
        $content = self::processTag($content, 'gallery', 'processGalleryCallback');
        
        return $content;
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