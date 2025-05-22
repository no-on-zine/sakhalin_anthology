<?php get_header();?>
<div class="cover">
    <div class="grid-wrap">
        <div class="photo-grid" id="photo-grid">
        </div>
    </div>
</div>

<div class="cover_bottom">
    <div>
        <div>
            <p>サハリンという言葉からあなたは何をイメージしますか？</p>
            <p>北海道のすぐ北にある島、かつて「樺太」とよばれ、南半分が日本だった、自然が豊か、天然資源が豊富などでしょうか。</p>
            <p>でもそこにどんな人たちが暮らしているかということはほとんど知らないかもしれません。</p>
        </div>
        <a class="button_black" href="<?php echo home_url('introduction');?>"><span>はじめに</span><span></span><span>Go to
                Introduction</span></a>
    </div>
    <div class="images">
        <div>
            <img src="<?php echo get_stylesheet_directory_uri();?>/images/top_cover_circle.svg" alt="" loading="lazy"
                decoding="async">
        </div>
        <div><img src="<?php echo get_stylesheet_directory_uri();?>/images/sakhalin_island.svg" alt="" loading="lazy"
                decoding="async">
        </div>
    </div>
</div>

<section class="anthology">
    <div class="container">
        <h2>Anthology</h2>
        <div class="posts">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php
                        $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 6
                        );
                        $the_query = new WP_Query( $args );
                        if ( $the_query->have_posts() ) :
                    ?>

                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="swiper-slide">
                        <a href="<?php the_permalink() ?>">
                            <div><?php the_post_thumbnail('full', array('loading' => 'lazy'));?></div>
                            <p class="title"><?php the_title(); ?></p>
                        </a>
                    </div>
                    <?php endwhile; ?>
                    <?php endif; wp_reset_postdata(); ?>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-scrollbar"></div>
            </div>
            <a class="button_black"
                href="<?php echo home_url('anthology');?>"><span>アンソロジー一覧を見る</span><span></span><span>Go to
                Anthology index</span></a>
        </div>
    </div>
</section>

<div class="bg_img_wrap">
    <div class="rellax bg_img img_01" data-rellax-percentage="0.5" data-rellax-speed="-5"></div>
</div>

<section class="dictionary">
    <div class="container">
        <h2>Dictionary</h2>
        <div class="scroll_area">

            <?php
            // 辞書リスト表示の共通関数
            function display_swiper_list($list_class, $term_slugs) {
                $args = array(
                    'post_type' => 'dictionary',
                    'posts_per_page' => -1,
                    'orderby' => 'rand',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'dictionary_abcorder',
                            'field' => 'slug',
                            'terms' => $term_slugs,
                            'operator' => 'IN'
                        )
                    )
                );

                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) : ?>
                    <div class="swiper <?php echo esc_attr($list_class); ?>">
                        <ul class="dictionary_list <?php echo esc_attr($list_class); ?> swiper-wrapper">
                            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                <li class="swiper-slide">
                                    <a href="<?php the_permalink(); ?>" class="modal-link" data-id="<?php the_ID(); ?>">
                                        &#035; <?php the_title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endif;
                wp_reset_postdata();
            }

            // スワイパーリストを表示する
            display_swiper_list('list_1 left_to_right', array('a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra', 'wa'));
            display_swiper_list('list_2 right_to_left', array('a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra', 'wa'));
            display_swiper_list('list_3 left_to_right', array('a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra', 'wa'));
            ?>

        </div>

        <a class="button_black" href="<?php echo home_url('dictionary'); ?>">
            <span>辞書一覧を見る</span>
            <span></span>
            <span>Go to Dictionary index</span>
        </a>
    </div>
</section>


<div class="bg_img_wrap">
    <div class="rellax bg_img img_02" data-rellax-percentage="0.5" data-rellax-speed="-5"></div>
</div>

<section class="map">
    <div class="container">
        <h2>Map</h2>
        <div class="flex">
            <div>
                <img src="<?php echo get_template_directory_uri();?>/images/top_map_illust.jpg" alt="" loading="lazy">
            </div>
            <div>
                <p>
                極寒の島サハリンには、古くから北方先住民族が自然とともに暮らしていました。歴史の変遷の中で、ロシア大陸からはスラヴ系ロシア人だけでなくウクライナ人、タタール人、朝鮮人など様々な民族が、また樺太時代には日本人とともに在日コリアンも移り住みます。地図には、アンソロジー中に出てくる場所にピンを立てています。
                </p>
                <a class="button_black" href="<?php echo home_url('maps');?>"><span>地図を見る</span><span></span><span>Go to
                Map</span></a>
            </div>
        </div>
    </div>
</section>

<section class="chronology">
    <div class="container">
        <h2>Chronology</h2>
        <div class="flex">
            <div>
                <img src="<?php echo get_template_directory_uri();?>/images/top_chronology.jpg" alt="" loading="lazy">
            </div>
            <div>
                <p>
                サハリンと深い繋がりのある日本・韓国・ロシアの三か所の近代〜現代を中心とした年表で歴史をたどります。
                </p>
                <a class="button_black" href="<?php echo home_url('chronology');?>"><span>年表を見る</span><span></span><span>Go to
                Chronology</span></a>
            </div>
        </div>
    </div>
</section>

<div class="bg_img_wrap">
    <div class="rellax bg_img img_03" data-rellax-percentage="0.5" data-rellax-speed="-5"></div>
</div>

<section class="credit">
    <div class="container">
        <h2>Credit</h2>
        <div class="credit_text">
            <div>
                <p>【企画・制作】 金サジ</p>
                <p>【協力】NPO法人 日本サハリン協会</p>
                <p>【助成】公益財団法人 韓昌祐・哲文化財団</p>
                <p>【WEBデザイン】野田菜奈美</p>
                <p>【WEB構築】 中川啓太</p>
            </div>
            <div>
                <p>お問い合わせ</p>
                <p>sakhalinanthology＊gmail.com（金サジ）</p>
                <p>＊を@に変えてご連絡ください。</p>
            </div>
        </div>
    </div>
</section>
<?php get_footer();?>