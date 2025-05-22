<?php 
$meta_description = "サハリン関わる人々から聞いたお話を掲載しています。ルーツ、世代、国籍、言葉、民族 、、、。さまざまな観点からサハリンという場所を知っていくための入り口となるでしょう。";
get_header();?>
<div class="contents_wrap">
    <div class="cover">
        <div class="title_area">
            <h2>アンソロジー</h2>
            <p class="lead_text">
                <span>
                    <span class="no_wrap">サハリン関わる人々から聞いたお話を掲載しています。ルーツ、世代、国籍、言葉、民族 、、、。</span>
                    さまざまな観点からサハリンという場所を知っていくための入り口となるでしょう。
                </span>
                </p>
            <div class="side_title_sticky">Anthology</div>
        </div>
    </div>

    <div class="post_wrap">
        <div class="post_list">
            <?php 
            // ページ番号の取得
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            // クエリ引数の設定
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            // クエリの実行
            $the_query = new WP_Query($args);

            // 投稿がある場合の処理
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <div class="anthology_post">
                        <a href="<?php the_permalink(); ?>">
                            <div class="thumbnail_wrap">
                                <div class="category_name">
                                    <p><?php echo get_the_category()[0]->name; ?></p>
                                </div>
                                <div class="thumbnail">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            </div>
                            <div class="title">
                                <h3><span><?php the_title(); ?></span></h3>
                                <div>
                                    <?php the_excerpt(); ?>
                                    <span>...</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; 
            else: ?>
                <p>投稿がありません。</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <?php 
            // ページネーションの表示
            if ($the_query->max_num_pages > 1) {
                echo paginate_links(array(
                    'base'      => get_pagenum_link(1) . '%_%',
                    'format'    => 'page/%#%/',
                    'current'   => max(1, $paged),
                    'mid_size'  => 1,
                    'total'     => $the_query->max_num_pages,
                    'prev_text' => '<',
                    'next_text' => '>',
                ));
            }

            // クエリ結果のリセット
            wp_reset_postdata();
            ?>
        </div>
    </div>


</div>
<?php get_footer();?>