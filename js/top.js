document.addEventListener('DOMContentLoaded', () => {
  // 共通のイベントリスナー追加関数
  const addEvent = (element, event, handler) =>
    element.addEventListener(event, handler);

  // rellax.js initialization
  const rellax = new Rellax('.rellax');

  // photo grid rotation
  const photoGrid = document.getElementById('photo-grid');
  const totalPhotos = 216;
  const displayedPhotos = 18;
  const rotatingPhotosIndices = [0, 5, 10, 15];
  let currentIndex = 0;
  let previousIndex = -1;
  let shuffledIndices = shuffleArray([...rotatingPhotosIndices]);

  const photos = Array.from(
    { length: totalPhotos },
    (_, i) =>
      `https://anthol65.com/wp-content/themes/sakhalin_anthology/images/cover_images/img${
        i + 1
      }.jpg`
  );
  let currentPhotos = getRandomPhotos(photos, displayedPhotos);
  displayPhotos(currentPhotos);

  function displayPhotos(photoArray) {
    photoGrid.innerHTML = photoArray
      .map(
        (photo, index) =>
          `<img src="${photo}" alt="" class="img_${
            index + 1
          }" loading="lazy" decoding="async">`
      )
      .join('');
  }

  function rotatePhotos() {
    setInterval(() => {
      let randomIndex = shuffledIndices[currentIndex];
      if (randomIndex === previousIndex) {
        currentIndex = (currentIndex + 1) % shuffledIndices.length;
        randomIndex = shuffledIndices[currentIndex];
      }

      let newPhoto;
      do {
        newPhoto = photos[Math.floor(Math.random() * totalPhotos)];
      } while (currentPhotos.includes(newPhoto));

      currentPhotos[randomIndex] = newPhoto;

      const imgElement = photoGrid.children[randomIndex];
      imgElement.style.opacity = 0;
      setTimeout(() => {
        imgElement.src = newPhoto;
        imgElement.style.opacity = 1;
      }, 2000);

      previousIndex = randomIndex;
      currentIndex = (currentIndex + 1) % shuffledIndices.length;
      if (currentIndex === 0) {
        shuffledIndices = shuffleArray([...rotatingPhotosIndices]);
      }
    }, 2000);
  }

  rotatePhotos();

  function getRandomPhotos(array, num) {
    return [...array].sort(() => 0.5 - Math.random()).slice(0, num);
  }

  function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
  }

  // swiper.js for anthology
  let mySwiper = null;
  const mediaQuery = window.matchMedia('(max-width: 960px)');

  const checkBreakpoint = (e) => {
    if (e.matches) {
      initSwiper();
    } else if (mySwiper) {
      mySwiper.destroy(false, true);
    }
  };

  const initSwiper = () => {
    mySwiper = new Swiper('.anthology .swiper', {
      loop: false,
      centeredSlides: true,
      slidesPerView: 1.2,
      spaceBetween: 20,
      pagination: {
        el: '.swiper-pagination',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      scrollbar: {
        el: '.swiper-scrollbar',
      },
      breakpoints: {
        520: {
          centeredSlides: false,
          slidesPerView: 1.7,
          spaceBetween: 30,
        },
        960: {
          spaceBetween: 20,
          slidesPerView: 6,
          centeredSlides: true,
        },
      },
    });
  };

  mediaQuery.addListener(checkBreakpoint);
  checkBreakpoint(mediaQuery);

  // swiper.js for dictionary lists
  const initDictionarySwiper = (selector, speed, reverseDirection = false) => {
    new Swiper(selector, {
      loop: true,
      slidesPerView: 'auto',
      speed,
      allowTouchMove: true,
      spaceBetween: 20,
      autoplay: {
        delay: 0,
        reverseDirection,
      },
      breakpoints: {
        960: {
          spaceBetween: 40,
        },
      },
    });
  };

  initDictionarySwiper('.dictionary .swiper.list_1', 7000);
  initDictionarySwiper('.dictionary .swiper.list_2', 7800, true);
  initDictionarySwiper('.dictionary .swiper.list_3', 7500);
});
