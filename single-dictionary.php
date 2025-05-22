<?php get_header();?>
<div class="container">
        <div class="post_content">
            <div class="post_content_title_wrap">
                <h2 class="post_title">
                    <span class="title"><?php the_title();?></span>
                    <?php $romaji = get_field('romaji');
                    if( !empty($romaji) ): ?>
                    <span class="romaji"><?php echo ($romaji); ?></span>
                    <?php endif; ?>
                </h2>
            </div>
            <?php
            // コンテンツの存在確認
            $maps = get_field('maps');
            $content = get_the_content();
            $content_class = '';

            // クラス判定
            if (!empty($maps) && !empty($content)) {
                $content_class = 'has-both';
            } elseif (!empty($maps)) {
                $content_class = 'has-map-only';
            } elseif (!empty($content)) {
                $content_class = 'has-content-only';
            }
            ?>
            <div class="content <?php echo $content_class; ?>">
                <?php if (!empty($maps)): ?>
                    <div class="iframe-wrapper">
                        <?php echo $maps; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($content)): ?>
                    <div class="text">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer();?>