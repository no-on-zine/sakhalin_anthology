<?php get_header(); ?>

<div class="contents_wrap">
    <div class="cover">
        <div class="title_area">
            <h2>アンソロジー</h2>
            <div class="side_title_sticky">Anthology</div>
        </div>
    </div>

    <section class="wp_area">
        <div class="container">
            <div class="post_content">
                <div class="post_cover">
                    <div class="category_name">
                        <p><?php echo get_the_category()[0]->name; ?></p>
                    </div>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="thumbnail">
                            <?php the_post_thumbnail('full', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>
                    <h2 class="post_title">
                        <?php the_title(); ?>
                    </h2>
                </div>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>

<?php
// 現在の投稿のカテゴリを取得（存在チェック付き）
$current_category = get_the_category();
if (!empty($current_category)) {
    $category_id = $current_category[0]->cat_ID;
} else {
    $category_id = null;
}

// WP_Query を使用して最新の3件の投稿を取得
$args = array(
    'posts_per_page' => 3,  // 表示する投稿の数
    'post__not_in' => array(get_the_ID()),  // 現在の投稿を除外
    'orderby' => 'rand',
    // 'category__in' => $category_id ? array($category_id) : '',  // 現在のカテゴリがあれば設定
);
$query = new WP_Query($args);

if ($query->have_posts()) : ?>
<div class="archives">
<div class="container">
    <h2>Other story</h2>
    <div class="archives_list">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="list">
            <a href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="thumbnail">
                        <?php the_post_thumbnail('full', ['loading' => 'lazy', 'alt' => get_the_title()]); ?>
                    </div>
                <?php endif; ?>
                <p class="title"><?php the_title(); ?></p>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</div>
</div>
<?php endif; ?>

<?php
// クエリのリセット
wp_reset_postdata();
?>

</div>

<?php get_footer(); ?>
