/**
 * Posts Loader - Fetches and renders posts via JavaScript
 * Maintains the same markup structure as the WordPress query loop
 */

(function () {
  "use strict";

  const postsPerPage = 10;
  let currentPage = 1;
  let totalPages = 1;
  let searchQuery = "";
  let selectedCategory = "";

  /**
   * Initialize the posts loader
   */
  function init() {
    if (!document.querySelector("#posts-container")) {
      return; // Not on a page with posts feed
    }

    // Initialize search
    initSearch();

    // Initialize category filters
    initCategoryFilters();

    // Load initial posts
    loadPosts(1);
  }

  /**
   * Initialize search functionality
   */
  function initSearch() {
    const searchForm = document.querySelector(".wp-block-search");
    const searchInput = document.querySelector(".wp-block-search__input");

    if (searchForm && searchInput) {
      searchForm.addEventListener("submit", function (e) {
        e.preventDefault();
        searchQuery = searchInput.value.trim();
        currentPage = 1;
        loadPosts(1);
      });

      // Search on input with debounce
      let searchTimeout;
      searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          searchQuery = searchInput.value.trim();
          currentPage = 1;
          loadPosts(1);
        }, 500);
      });
    }
  }

  /**
   * Initialize category filters
   */
  async function initCategoryFilters() {
    const categoriesContainer = document.querySelector(
      ".wp-block-categories-list",
    );
    if (!categoriesContainer) return;

    try {
      // Fetch categories
      const response = await fetch(
        "/wp-json/wp/v2/categories?per_page=100&hide_empty=true",
      );
      const categories = await response.json();

      // Render categories
      renderCategories(categoriesContainer, categories);
    } catch (error) {
      console.error("Error loading categories:", error);
    }
  }

  /**
   * Render category filters
   */
  function renderCategories(container, categories) {
    let categoriesHTML = `
            <li class="cat-item cat-item-all ${!selectedCategory ? "active" : ""}">
                <a href="#" data-category="">All</a>
            </li>
        `;

    // Show only first 2 categories
    const topCategories = categories.slice(0, 3);
    topCategories.forEach((cat) => {
      categoriesHTML += `
                <li class="cat-item cat-item-${cat.id} ${selectedCategory == cat.id ? "active" : ""}">
                    <a href="#" data-category="${cat.id}">
                        ${escapeHtml(cat.name)}
                    </a>
                </li>
            `;
    });

    container.innerHTML = categoriesHTML;

    // Add click handlers
    container.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        selectedCategory = this.getAttribute("data-category");

        // Update active state
        container
          .querySelectorAll(".cat-item")
          .forEach((item) => item.classList.remove("active"));
        this.parentElement.classList.add("active");

        // Reload posts
        currentPage = 1;
        loadPosts(1);
      });
    });
  }

  /**
   * Fetch posts from WordPress REST API
   */
  async function loadPosts(page = 1) {
    const loadingEl = document.getElementById("posts-loading");
    const containerEl = document.getElementById("posts-container");
    const paginationEl = document.getElementById("posts-pagination");
    const noResultsEl = document.getElementById("posts-no-results");

    // Show loading
    if (loadingEl) loadingEl.style.display = "block";
    if (containerEl) containerEl.style.display = "none";
    if (paginationEl) paginationEl.style.display = "none";
    if (noResultsEl) noResultsEl.style.display = "none";

    try {
      // Build API URL with filters
      let apiUrl = `/wp-json/wp/v2/posts?per_page=${postsPerPage}&page=${page}&_embed=true&order=desc&orderby=date`;

      if (searchQuery) {
        apiUrl += `&search=${encodeURIComponent(searchQuery)}`;
      }

      if (selectedCategory) {
        apiUrl += `&categories=${selectedCategory}`;
      }

      const response = await fetch(apiUrl);

      if (!response.ok) {
        throw new Error("Failed to fetch posts");
      }

      const posts = await response.json();
      totalPages = parseInt(response.headers.get("X-WP-TotalPages") || "1");
      currentPage = page;

      // Hide loading
      if (loadingEl) loadingEl.style.display = "none";

      // Render posts
      if (posts.length > 0) {
        renderPosts(posts, containerEl);
        renderPagination(paginationEl);
        if (containerEl) containerEl.style.display = "block";
        if (paginationEl) paginationEl.style.display = "flex";
      } else {
        if (noResultsEl) noResultsEl.style.display = "block";
      }
    } catch (error) {
      console.error("Error loading posts:", error);
      if (loadingEl) {
        loadingEl.innerHTML =
          '<p style="color: red;">Error loading posts. Please try again later.</p>';
      }
    }
  }

  /**
   * Render posts maintaining the original markup structure
   */
  function renderPosts(posts, containerEl) {
    if (!containerEl) return;

    const postsHTML = posts
      .map((post) => {
        const featuredImage =
          post._embedded && post._embedded["wp:featuredmedia"]
            ? post._embedded["wp:featuredmedia"][0]
            : null;

        const categories =
          post._embedded &&
          post._embedded["wp:term"] &&
          post._embedded["wp:term"][0]
            ? post._embedded["wp:term"][0]
            : [];

        const tags =
          post._embedded &&
          post._embedded["wp:term"] &&
          post._embedded["wp:term"][1]
            ? post._embedded["wp:term"][1]
            : [];

        return `
                <div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
                    ${renderFeaturedImage(post, featuredImage)}
                    ${renderTaxonomy(categories, tags)}
                    ${renderPostTitle(post)}
                    ${renderPostExcerpt(post)}
                </div>
            `;
      })
      .join("");

    containerEl.innerHTML = postsHTML;
  }

  /**
   * Render featured image
   */
  function renderFeaturedImage(post, featuredImage) {
    if (!featuredImage) return "";

    const imageUrl =
      featuredImage.media_details?.sizes?.large?.source_url ||
      featuredImage.source_url;
    const imageAlt = featuredImage.alt_text || post.title.rendered;

    return `
            <figure class="wp-block-post-featured-image">
                <a href="${post.link}" target="_self">
                    <img 
                        src="${imageUrl}" 
                        alt="${escapeHtml(imageAlt)}"
                        style="aspect-ratio: 3/1.2; object-fit: cover; border-radius: 12px; width: 100%;"
                    />
                </a>
            </figure>
        `;
  }

  /**
   * Render taxonomy (categories and tags)
   */
  function renderTaxonomy(categories, tags) {
    const categoryHTML = categories
      .map(
        (cat) =>
          `<span class="wp-block-post-terms__term"><a href="${cat.link}">${escapeHtml(cat.name)}</a></span>`,
      )
      .join(" ");

    const tagHTML = tags
      .map(
        (tag) =>
          `<span class="wp-block-post-terms__term"><a href="${tag.link}">${escapeHtml(tag.name)}</a></span>`,
      )
      .join(" ");

    return `
            <div id="taxonomy" style="gap: 8px; display: flex; flex-wrap: wrap;">
                <div class="wp-block-post-terms">${categoryHTML}</div>
                <div class="wp-block-post-terms">${tagHTML}</div>
            </div>
        `;
  }

  /**
   * Render post title
   */
  function renderPostTitle(post) {
    return `
            <h2 class="wp-block-post-title" style="margin-top: 12px; font-size: 36px; font-weight: 700; line-height: 29px; color: #292E3D;">
                <a href="${post.link}" target="_self">${post.title.rendered}</a>
            </h2>
        `;
  }

  /**
   * Render post excerpt
   */
  function renderPostExcerpt(post) {
    const excerpt = post.excerpt.rendered
      .replace(/<[^>]*>/g, "") // Strip HTML tags
      .trim();

    // Limit to 40 words
    const words = excerpt.split(/\s+/);
    const limitedExcerpt = words.slice(0, 40).join(" ");
    const finalExcerpt =
      words.length > 40 ? limitedExcerpt + "..." : limitedExcerpt;

    return `
            <div class="wp-block-post-excerpt" style="margin-top: 4px; font-size: 17px; line-height: 22px; font-weight: 400; color: #667399;">
                <p class="wp-block-post-excerpt__excerpt">${escapeHtml(finalExcerpt)}</p>
            </div>
        `;
  }

  /**
   * Render pagination
   */
  function renderPagination(paginationEl) {
    if (!paginationEl || totalPages <= 1) {
      if (paginationEl) paginationEl.style.display = "none";
      return;
    }

    let paginationHTML = "";

    // Previous button
    if (currentPage > 1) {
      paginationHTML += `
                <a 
                    href="#" 
                    class="wp-block-query-pagination-previous" 
                    data-page="${currentPage - 1}"
                    style="text-decoration: none; padding: 8px 12px;"
                >
                    ← Previous
                </a>
            `;
    }

    // Page numbers
    paginationHTML +=
      '<div class="wp-block-query-pagination-numbers" style="display: flex; gap: 4px;">';
    for (let i = 1; i <= totalPages; i++) {
      if (i === currentPage) {
        paginationHTML += `<span class="page-numbers current" aria-current="page" style="padding: 8px 12px; font-weight: bold; background: #292E3D; color: white; border-radius: 4px;">${i}</span>`;
      } else {
        paginationHTML += `<a href="#" class="page-numbers" data-page="${i}" style="padding: 8px 12px; text-decoration: none; border-radius: 4px;">${i}</a>`;
      }
    }
    paginationHTML += "</div>";

    // Next button
    if (currentPage < totalPages) {
      paginationHTML += `
                <a 
                    href="#" 
                    class="wp-block-query-pagination-next" 
                    data-page="${currentPage + 1}"
                    style="text-decoration: none; padding: 8px 12px;"
                >
                    Next →
                </a>
            `;
    }

    paginationEl.innerHTML = paginationHTML;
    paginationEl.style.display = "flex";
    paginationEl.style.justifyContent = "center";
    paginationEl.style.gap = "16px";
    paginationEl.style.alignItems = "center";

    // Add click handlers
    paginationEl.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const page = parseInt(this.getAttribute("data-page"));
        loadPosts(page);

        // Scroll to top of posts
        const postsContainer = document.querySelector("#posts-container");
        if (postsContainer) {
          postsContainer.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      });
    });
  }

  /**
   * Escape HTML to prevent XSS
   */
  function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
  }

  // Initialize when DOM is ready
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
