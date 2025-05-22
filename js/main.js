document.addEventListener('DOMContentLoaded', () => {
  // クラス名が「scroll-in」の要素を取得
  const elementsToObserve = document.querySelectorAll('.scroll-in');

  // IntersectionObserverのコールバック関数
  const handleIntersection = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('displayed'); // 表示クラスを付与
        observer.unobserve(entry.target); // 監視を解除
      }
    });
  };

  // IntersectionObserverの設定
  const observerOptions = {
    root: null, // ビューポートを基準
    rootMargin: '0px', // 余白なし
    threshold: 0.3, // 要素が少しでも見えたら発火
  };

  // 初期化関数
  const initObserver = () => {
    const html = document.documentElement;

    // 条件チェック: 処理を実行させない条件
    if (html.classList.contains('wf-loading')) {
      console.log('現在wf-loadingクラスが存在するため、処理は保留中です。');
      return;
    }

    // 条件チェック: 処理を実行する条件
    if (
      html.classList.contains('wf-active') ||
      html.classList.contains('wf-inactive')
    ) {
      console.log('wf-activeまたはwf-inactiveクラスを検知。処理を実行します。');

      // IntersectionObserverのインスタンスを作成
      const observer = new IntersectionObserver(
        handleIntersection,
        observerOptions
      );

      // 各要素を監視
      elementsToObserve.forEach((element) => observer.observe(element));
    } else {
      console.log('wf-activeクラスが未検知。処理をスキップします。');
    }
  };

  // 実行タイミングを調整できるように関数をエクスポート
  const startObserverWithDelay = (delay = 0) => {
    setTimeout(initObserver, delay);
  };

  // 必要に応じて以下のコードで呼び出し可能
  startObserverWithDelay(1000); // 例: 1秒後に実行

  // hamburger menu
  const hamburger = document.querySelector('.hamburger');
  hamburger.addEventListener('click', (event) => {
    event.preventDefault();
    hamburger.classList.toggle('active');
    document.querySelector('.nav_wrap').classList.toggle('active');
  });

  // modal機能
  const modal = document.getElementById('modal');
  const modalOverlay = document.getElementById('modal-overlay');
  const modalContent = document.getElementById('modal-content');
  const closeModal = document.getElementById('close-modal');
  const modalLinks = document.querySelectorAll(
    '.modal-link, section.wp_area .content a, .chronology .content a[data-type=dictionary]'
  );

  modalLinks.forEach((link) => {
    link.addEventListener('click', (event) => {
      event.preventDefault();
      const url = link.getAttribute('href');
      modalContent.innerHTML = 'Loading...';

      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then((html) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const content = doc.querySelector('main');
          modalContent.innerHTML = content
            ? content.innerHTML
            : 'Content not found';
        })
        .catch((error) => {
          modalContent.innerHTML = 'Error loading content';
          console.error('Error:', error);
        });

      modal.classList.toggle('active');
      modalOverlay.classList.toggle('active');
    });
  });

  // モーダルを閉じる処理
  closeModal.addEventListener('click', function () {
    modal.classList.toggle('active'); // クラスをトグル
    modalOverlay.classList.toggle('active'); // クラスをトグル
  });

  // オーバーレイをクリックしてもモーダルを閉じる
  modalOverlay.addEventListener('click', function () {
    modal.classList.toggle('active'); // クラスをトグル
    modalOverlay.classList.toggle('active'); // クラスをトグル
  });

  // go to top button
  const button = document.querySelector('.page_top');
  button.addEventListener('click', () =>
    window.scroll({ top: 0, behavior: 'smooth' })
  );
  window.addEventListener('scroll', () => {
    button.classList.toggle('is-active', window.scrollY > 100);
  });
});
