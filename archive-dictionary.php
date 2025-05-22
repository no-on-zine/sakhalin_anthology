<?php
$meta_description = "アンソロジー中に出てくるキーワードをピックアップした一覧です。単語をクリックしていただくと、概要をご覧いただけます。";
get_header();?>

<div class="contents_wrap">
    <div class="cover">
        <div class="title_area">
            <h2 class="kanji">辞書</h2>
            <p class="lead_text">
                <span>アンソロジー中に出てくるキーワードをピックアップした一覧です。<br>
            単語をクリックしていただくと、概要をご覧いただけます。</span></p>
            <div class="side_title_sticky">Dictionary</div>
        </div>
    </div>

    <div class="dictionary_list_wrap">

    <?php
    // 辞書を表示するための共通関数
    function display_dictionary_section($term_slug, $heading_char) {
        $args = array(
            'post_type' => 'dictionary',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'dictionary_abcorder', // タクソノミーを指定
                    'field' => 'slug', // ターム名をスラッグで指定
                    'terms' => $term_slug, // 表示したいタームをスラッグで指定
                    'operator' => 'IN'
                ),
            ),
        );

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) :
            ?>
            <div class="dictionary_list">
                <p><?php echo esc_html($heading_char); ?></p>
                <ul>
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" class="modal-link" data-id="<?php the_ID(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="dictionary_list">
                <p><?php echo esc_html($heading_char); ?></p>
            </div>
        <?php
        endif;
        wp_reset_postdata();
    }

    // 表示したいスラッグと見出し文字のリスト
    $sections = array(
        'a' => 'あ',
        'ka' => 'か',
        'sa' => 'さ',
        'ta' => 'た',
        'na' => 'な',
        'ha' => 'は',
        'ma' => 'ま',
        'ya' => 'や',
        'ra' => 'ら',
        'wa' => 'わ',
    );

    // 各スラッグに対して辞書セクションを表示
    foreach ($sections as $slug => $heading) {
        display_dictionary_section($slug, $heading);
    }
    ?>

</div>

</div>
<?php get_footer();?>