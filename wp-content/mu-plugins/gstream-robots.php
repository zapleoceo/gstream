<?php
/**
 * Custom robots.txt additions for gstream.com.ua
 * AI crawlers: allow GPTBot, ClaudeBot, PerplexityBot
 * Block: AhrefsBot, MJ12bot, DotBot (scrapers)
 */
add_filter("robots_txt", function(string $output, string $public): string {
    $extra  = "\n";
    $extra .= "# AI search crawlers — welcome\n";
    $extra .= "User-agent: GPTBot\n";
    $extra .= "Allow: /\n";
    $extra .= "Disallow: /wp-admin/\n";
    $extra .= "Disallow: /checkout/\n";
    $extra .= "Disallow: /cart/\n";
    $extra .= "Disallow: /my-account/\n";
    $extra .= "\n";
    $extra .= "User-agent: ClaudeBot\n";
    $extra .= "Allow: /\n";
    $extra .= "Disallow: /wp-admin/\n";
    $extra .= "Disallow: /checkout/\n";
    $extra .= "Disallow: /cart/\n";
    $extra .= "Disallow: /my-account/\n";
    $extra .= "\n";
    $extra .= "User-agent: PerplexityBot\n";
    $extra .= "Allow: /\n";
    $extra .= "Disallow: /wp-admin/\n";
    $extra .= "Disallow: /checkout/\n";
    $extra .= "Disallow: /cart/\n";
    $extra .= "Disallow: /my-account/\n";
    $extra .= "\n";
    $extra .= "User-agent: Applebot-Extended\n";
    $extra .= "Allow: /\n";
    $extra .= "\n";
    $extra .= "# Bad bots — block\n";
    $extra .= "User-agent: AhrefsBot\n";
    $extra .= "Disallow: /\n";
    $extra .= "\n";
    $extra .= "User-agent: MJ12bot\n";
    $extra .= "Disallow: /\n";
    $extra .= "\n";
    $extra .= "User-agent: DotBot\n";
    $extra .= "Disallow: /\n";
    $extra .= "\n";
    $extra .= "# LLM context file\n";
    $extra .= "# llms.txt: https://gstream.com.ua/llms.txt\n";

    return $output . $extra;
}, 20, 2);

// Regenerate physical sitemap_index.xml when content changes
add_action("save_post", "gstream_regenerate_sitemap_index", 20);
add_action("edited_term", "gstream_regenerate_sitemap_index", 20);

function gstream_regenerate_sitemap_index(): void {
    $home = get_option("siteurl");
    $response = wp_remote_get($home . "/?sitemap=1", ["timeout" => 10, "sslverify" => false]);
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $body = wp_remote_retrieve_body($response);
        $path = ABSPATH . "sitemap_index.xml";
        file_put_contents($path, $body);
    }
}
