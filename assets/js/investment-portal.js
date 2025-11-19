document.addEventListener('DOMContentLoaded', () => {
  // Swiper initialization.
  if (typeof Swiper !== 'undefined') {
    new Swiper('.swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  }

  // Load more land plots.
  const loadMoreButton = document.getElementById('load-more-plots');
  if (loadMoreButton) {
    loadMoreButton.addEventListener('click', () => {
      const currentPage = parseInt(loadMoreButton.dataset.page, 10);
      const maxPages = parseInt(loadMoreButton.dataset.maxPages, 10);
      const nextPage = currentPage + 1;

      fetch(`/wp-json/wp/v2/land_plot?page=${nextPage}&_embed`)
        .then(response => response.json())
        .then(posts => {
          const grid = document.querySelector('.land-plots-grid');
          posts.forEach(post => {
            const postElement = document.createElement('div');
            postElement.classList.add('land-plot-card');
            postElement.innerHTML = `
              ${post._embedded['wp:featuredmedia'] ? `<div class="land-plot-card-image"><img src="${post._embedded['wp:featuredmedia'][0].source_url}" alt="${post.title.rendered}"></div>` : ''}
              <div class="land-plot-card-content">
                <h3>${post.title.rendered}</h3>
                ${post.acf.area_hectares ? `<p>Area: ${post.acf.area_hectares} ha</p>` : ''}
              </div>
            `;
            grid.appendChild(postElement);
          });

          if (nextPage >= maxPages) {
            loadMoreButton.style.display = 'none';
          } else {
            loadMoreButton.dataset.page = nextPage;
          }
        });
    });
  }
});
