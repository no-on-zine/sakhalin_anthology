<?php

get_header();

// cover_imagesディレクトリ内の画像を取得
$image_dir = get_template_directory() . '/images/cover_images/';
$images = glob($image_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

// ランダムに1枚選択
$random_image = '';
if (!empty($images)) {
    $random_image = basename($images[array_rand($images)]);
}
?>

<div class="page-404">
	<div class="content-wrap" <?php if ($random_image): ?> style="background-image: url('<?php echo esc_url(get_template_directory_uri() . '/images/cover_images/' . $random_image); ?>')" <?php endif; ?>">
		
	<div>
		<h2>404 NOT FOUND</h2>
			<p>お探しのページは見つかりませんでした</p>
			<?php // トップに戻るボタン ?>
			<a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-top">トップページに戻る</a>
		</div>
	</div>
</div>

<?php

get_footer();