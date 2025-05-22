<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://use.typekit.net" crossorigin>
    <link rel="dns-prefetch" href="https://use.typekit.net">
    <script>
        (function (d) {
    var config = {
        kitId: 'ufc3qnn',
        scriptTimeout: 3000,
        async: true,
        },
        h = d.documentElement,
        t = setTimeout(function () {
        h.className = h.className.replace(/\bwf-loading\b/g, '') + ' wf-inactive';
        }, config.scriptTimeout),
        tk = d.createElement('script'),
        f = false,
        s = d.getElementsByTagName('script')[0],
        a;
    h.className += ' wf-loading';
    tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
    tk.async = true;
    tk.onload = tk.onreadystatechange = function () {
        a = this.readyState;
        if (f || (a && a != 'complete' && a != 'loaded')) return;
        f = true;
        clearTimeout(t);
        try {
        Typekit.load(config);
        } catch (e) {}
    };
    s.parentNode.insertBefore(tk, s);
    })(document);
    </script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

<div class="spinner-box">
  <div class="circle-border">
    <div class="circle-core"></div>
  </div>  
</div>

    <div id="page_wrapper">
        <header class="<?php echo is_front_page() || is_home() ? 'home_header' : 'page_header'; ?>">
            <div class="logo_hamburger">
                <h1>
                    <a href="<?php echo home_url();?>">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/images/logo.svg" loading="lazy"
                            decoding="async" alt="サハリンアンソロジー">
                    </a>
                </h1>
                <div class="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <div class="nav_wrap">
                <nav>
                    <ul>
                        <li><a href="<?php echo home_url();?>">トップページ</a></li>
                        <li><a href="<?php echo home_url('anthology');?>">アンソロジー</a></li>
                        <li><a href="<?php echo home_url('introduction');?>">はじめに</a></li>
                        <li><a href="<?php echo home_url('dictionary');?>">辞書</a></li>
                        <li><a href="<?php echo home_url('maps');?>">地図</a></li>
                        <li><a href="<?php echo home_url('chronology');?>">年表</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>