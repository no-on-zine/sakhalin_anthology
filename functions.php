<?php
// JPEGのクオリティを100に設定
add_filter('jpeg_quality', fn($arg) => 100);
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

// JS・CSSファイルを追加
function add_files() {
    // jQueryを外す
    wp_deregister_script('jquery');

    // JSファイル
    if (is_front_page() || is_home()) {
        wp_enqueue_script('rellax', 'https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.min.js', [], null, true);
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
        wp_enqueue_script('top', get_template_directory_uri() . '/js/top.js', [], filemtime(get_theme_file_path('/js/top.js')), true);
    }

    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', [], filemtime(get_theme_file_path('/js/main.js')), true);

    // CSSファイル
    if (is_front_page() || is_home()) {
        wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', []);
        wp_enqueue_style('top', get_stylesheet_directory_uri() . '/stylesheets/css/top.css', [], filemtime(get_theme_file_path('/stylesheets/css/top.css')));
    } elseif (is_page() || !is_archive() && !is_single()) {
        wp_enqueue_style('page', get_stylesheet_directory_uri() . '/stylesheets/css/page.css', [], filemtime(get_theme_file_path('/stylesheets/css/page.css')));
    } elseif (is_archive() || is_single()) {
        wp_enqueue_style('single', get_stylesheet_directory_uri() . '/stylesheets/css/single.css', [], filemtime(get_theme_file_path('/stylesheets/css/single.css')));
    }
}
add_action('wp_enqueue_scripts', 'add_files');

// 画像の添付ファイルページの404リダイレクト
function attachment404() {
    if (is_attachment()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
    }
}
add_action('template_redirect', 'attachment404');

// 管理メニューからコメントを削除
function remove_menus() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_menus');

// 不要なheadタグの削除
$head_actions = [
    'feed_links', 2,
    'feed_links_extra', 3,
    'rsd_link',
    'wlwmanifest_link',
    'index_rel_link',
    'parent_post_rel_link', 10,
    'start_post_rel_link', 10,
    'adjacent_posts_rel_link', 10,
    'wp_generator',
    'rest_output_link_wp_head',
    'wp_oembed_add_discovery_links',
    'wp_oembed_add_host_js',
    'print_emoji_detection_script', 7,
    'admin_print_scripts' => 'print_emoji_detection_script',
    'wp_print_styles' => 'print_emoji_styles',
    'admin_print_styles' => 'print_emoji_styles',
];

foreach ($head_actions as $action => $priority) {
    remove_action('wp_head', is_int($action) ? $priority : $action);
}

// 投稿のラベルをカスタマイズ

function Change_menulabel() {
  global $menu;
  global $submenu;
  $name = 'アンソロジー';
  $menu[5][0] = $name;
  $submenu['edit.php'][5][0] = $name.'一覧';
  $submenu['edit.php'][10][0] = '新規'.$name.'投稿';
}
function Change_objectlabel() {
  global $wp_post_types;
  $name = 'アンソロジー';
  $labels = &$wp_post_types['post']->labels;
  $labels->name = $name;
  $labels->singular_name = $name;
  $labels->add_new = _x('追加', $name);
  $labels->add_new_item = $name.'の新規追加';
  $labels->edit_item = $name.'の編集';
  $labels->new_item = '新規'.$name;
  $labels->view_item = $name.'を表示';
  $labels->search_items = $name.'を検索';
  $labels->not_found = $name.'が見つかりませんでした';
  $labels->not_found_in_trash = 'ゴミ箱に'.$name.'は見つかりませんでした';
}
add_action( 'init', 'Change_objectlabel' );
add_action( 'admin_menu', 'Change_menulabel' );

function my_unregister_taxonomies() {
  global $wp_taxonomies;
  // 「カテゴリー」の非表示
  // if (!empty($wp_taxonomies['category']->object_type)) {
  //   foreach ($wp_taxonomies['category']->object_type as $i => $object_type) {
  //     if ($object_type == 'post') {
  //       unset($wp_taxonomies['category']->object_type[$i]);
  //     }
  //   }
  // }
  // 「タグ」の非表示
  if (!empty($wp_taxonomies['post_tag']->object_type)) {
    foreach ($wp_taxonomies['post_tag']->object_type as $i => $object_type) {
      if ($object_type == 'post') {
        unset($wp_taxonomies['post_tag']->object_type[$i]);
      }
    }
  }
  return true;
}
add_action('init', 'my_unregister_taxonomies');

// パーマリンクのカスタマイズ
add_filter('pre_post_link', fn($permalink) => '/anthology' . $permalink);
add_filter('post_rewrite_rules', function ($post_rewrite) {
    $return_rule = [];
    foreach ($post_rewrite as $regex => $rewrite) {
        $return_rule['anthology/' . $regex] = $rewrite;
    }
    return $return_rule;
});

// bodyにページ名を追加
add_filter('body_class', function ($classes) {
    if (is_page()) {
        $page = get_post();
        $classes[] = $page->post_name;
    }
    return $classes;
});

// 抜粋の長さと省略記号の変更
add_filter('excerpt_length', fn($length) => 80, 999);
add_filter('excerpt_more', fn($more) => '', 999);

function my_meta_ogp() {
  if( is_front_page() || is_home() || is_singular() ){
    global $post;
    $ogp_title = '';
    $ogp_descr = '';
    $ogp_url = '';
    $ogp_img = '';
    $insert = '';
    $meta_description = '';

    if ( is_singular() ) { // 記事＆固定ページ
        setup_postdata($post);
        $ogp_title = $post->post_title;
        
        // ここで$meta_descriptionを使用
        global $meta_description; 
        if (empty($meta_description)) {
            $meta_description = mb_substr(get_the_excerpt(), 0, 100); // 抜粋を使用
        }
        $ogp_descr = $meta_description; // OGP説明に割り当て
        
        $ogp_url = get_permalink();
        wp_reset_postdata();
    } elseif ( is_front_page() || is_home() ) { // トップページ
        $ogp_title = get_bloginfo('name');
        $meta_description = get_bloginfo('description'); // トップページの説明文を使用
        $ogp_descr = $meta_description;
        $ogp_url = home_url();
    }

    // og:type
    $ogp_type = ( is_front_page() || is_home() ) ? 'website' : 'article';

    // og:image
    if ( is_singular() && has_post_thumbnail() ) {
        $ps_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
        $ogp_img = $ps_thumb[0];
    } else {
        $ogp_img = 'https://anthol65.com/wp-content/uploads/2024/12/ogp.png';
    }

    // 出力するOGPタグをまとめる
    $insert .= '<meta property="og:title" content="'.esc_attr($ogp_title).'" />' . "\n";
    $insert .= '<meta property="og:description" content="'.esc_attr($ogp_descr).'" />' . "\n"; // $ogp_descrに$meta_descriptionの値が設定済み
    $insert .= '<meta property="og:type" content="'.$ogp_type.'" />' . "\n";
    $insert .= '<meta property="og:url" content="'.esc_url($ogp_url).'" />' . "\n";
    $insert .= '<meta property="og:image" content="'.esc_url($ogp_img).'" />' . "\n";
    $insert .= '<meta property="og:site_name" content="'.esc_attr(get_bloginfo('name')).'" />' . "\n";
    $insert .= '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    $insert .= '<meta name="twitter:site" content="" />' . "\n";
    $insert .= '<meta property="og:locale" content="ja_JP" />' . "\n";

    // facebookのapp_id（設定する場合）
    //$insert .= '<meta property="fb:app_id" content="ここにappIDを入力">' . "\n";
    // app_idを設定しない場合ここまで消す

    echo $insert;
  }
} // END my_meta_ogp

add_action('wp_head','my_meta_ogp');//headにOGPを出力


// AJAXリクエストかどうかを判定する関数
function is_ajax_request() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// dictionaryの詳細ページへのアクセスをコントロール
function control_dictionary_access() {
    if (is_singular('dictionary') && !is_ajax_request()) {
        wp_redirect(home_url()); // または wp_redirect(home_url('/404'));
        exit;
    }
}
add_action('template_redirect', 'control_dictionary_access');

function add_meta_description() {
  if (is_page()) {
      global $meta_description;

      // テンプレート内で定義された変数を使用
      if (!empty($meta_description)) {
          $description = $meta_description;
      } else {
          $description = get_bloginfo('description'); // デフォルトの説明文
      }
  } else if (is_single()) {
      $description = get_the_excerpt();
  } else {
      $description = get_bloginfo('description');
  }

  echo '<meta name="description" content="' . esc_attr(strip_tags($description)) . '">' . PHP_EOL;
}
add_action('wp_head', 'add_meta_description');
