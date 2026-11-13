// Kegunaan file: Mengatur dialog pencarian global dan hasil pencarian di halaman.
const searchDialog = document.getElementById('smaart-global-search-dialog');
const searchTrigger = document.querySelector('.smaart-search-trigger');
const searchClose = document.querySelector('.smaart-search-close');
const searchInput = document.getElementById('smaart-search-input');
const searchForm = document.querySelector('.smaart-search-form');
const searchStatus = document.getElementById('smaart-search-status');
const searchResults = document.getElementById('smaart-search-results');
const navToggle = document.querySelector('.nav-toggle');

// Samakan huruf dan hilangkan tanda aksen agar pencarian lebih mudah cocok.
const normalizeSearchText = (value) => value
    .toLocaleLowerCase('id-ID')
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');

const searchEntries = [];

document.querySelectorAll('#pillars .home-pillar-card, #services .pillar-card').forEach((card) => {
    const title = card.querySelector('h3')?.textContent.trim();
    if (!title) {
        return;
    }

    const details = [...card.querySelectorAll('p, li')]
        .map((element) => element.textContent.trim())
        .filter(Boolean);

    searchEntries.push({
        title,
        category: 'Layanan',
        description: details.join(' '),
        href: card.closest('#pillars') ? '#pillars' : '#services',
    });
});

document.querySelectorAll(
    '#featured-products .home-product, #featured-products .solution-feature, #featured-products .solution-card'
).forEach((card) => {
    const title = card.querySelector('h3')?.textContent.trim();
    if (!title) {
        return;
    }

    const description = card.querySelector('.solution-copy p, p')?.textContent.trim() || '';
    searchEntries.push({
        title,
        category: 'Produk',
        description,
        href: '#featured-products',
    });
});

const contactSection = document.querySelector('#contact');
const contactTitle = contactSection?.querySelector('.home-contact-copy h2, .contact-copy h2')?.textContent.trim();
if (contactSection && contactTitle) {
    const details = [...contactSection.querySelectorAll(
        '.home-contact-copy p, .home-contact-details p, .home-contact-details a, .contact-copy p, .contact-list li'
    )]
        .map((element) => element.textContent.trim())
        .filter(Boolean);

    searchEntries.push({
        title: contactTitle,
        category: 'Kontak',
        description: details.join(' '),
        href: '#contact',
    });
}

// Tutup dialog pencarian jika sedang terbuka.
const closeSearch = () => {
    if (searchDialog?.open) {
        searchDialog.close();
    }
};

// Tempatkan dialog dekat tombol pencarian dan tetap di dalam layar.
const positionSearchDialog = () => {
    if (!searchDialog || !searchTrigger) {
        return;
    }

    const triggerBounds = searchTrigger.getBoundingClientRect();
    const viewportPadding = 16;
    const dialogWidth = Math.min(460, window.innerWidth - viewportPadding * 2);
    const left = Math.max(
        viewportPadding,
        Math.min(triggerBounds.right - dialogWidth, window.innerWidth - dialogWidth - viewportPadding),
    );
    const top = Math.min(
        triggerBounds.bottom + 8,
        window.innerHeight - searchDialog.offsetHeight - viewportPadding,
    );

    searchDialog.style.left = `${left}px`;
    searchDialog.style.top = `${Math.max(viewportPadding, top)}px`;
    searchDialog.style.width = `${dialogWidth}px`;
};

// Cari produk, layanan, atau kontak lalu tampilkan hasil yang cocok.
const renderSearchResults = () => {
    if (!searchInput || !searchResults || !searchStatus) {
        return;
    }

    const query = normalizeSearchText(searchInput.value.trim());
    searchResults.replaceChildren();

    if (!query) {
        searchStatus.textContent = 'Ketik kata kunci untuk mulai mencari.';
        return;
    }

    const terms = query.split(/\s+/);
    const matches = searchEntries.filter((entry) => {
        const searchableText = normalizeSearchText(`${entry.title} ${entry.category} ${entry.description}`);
        return terms.every((term) => searchableText.includes(term));
    }).slice(0, 8);

    if (!matches.length) {
        searchStatus.textContent = 'Tidak ada hasil yang cocok. Coba kata kunci lain.';
        return;
    }

    searchStatus.textContent = `${matches.length} hasil ditemukan.`;
    matches.forEach((entry) => {
        const item = document.createElement('li');
        const link = document.createElement('a');
        const category = document.createElement('span');
        const title = document.createElement('strong');
        const description = document.createElement('small');

        link.href = entry.href;
        category.className = 'smaart-search-result-category';
        category.textContent = entry.category;
        title.textContent = entry.title;
        description.textContent = entry.description;
        link.append(category, title, description);
        link.addEventListener('click', () => {
            if (navToggle?.getAttribute('aria-expanded') === 'true') {
                navToggle.click();
            }
            closeSearch();
        });
        item.append(link);
        searchResults.append(item);
    });
};

if (searchDialog && searchTrigger && searchInput && searchClose && searchForm) {
    searchTrigger.addEventListener('click', () => {
        positionSearchDialog();
        searchDialog.showModal();
        positionSearchDialog();
        searchTrigger.setAttribute('aria-expanded', 'true');
        searchTrigger.setAttribute('aria-label', 'Tutup pencarian');
        searchInput.focus();
    });

    window.addEventListener('resize', () => {
        if (searchDialog.open) {
            positionSearchDialog();
        }
    });

    searchClose.addEventListener('click', closeSearch);
    searchInput.addEventListener('input', renderSearchResults);
    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        searchResults?.querySelector('a')?.click();
    });
    searchDialog.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            event.preventDefault();
            closeSearch();
        }
    });
    searchDialog.addEventListener('click', (event) => {
        if (event.target === searchDialog) {
            closeSearch();
        }
    });
    searchDialog.addEventListener('close', () => {
        searchTrigger.setAttribute('aria-expanded', 'false');
        searchTrigger.setAttribute('aria-label', 'Buka pencarian');
        searchTrigger.focus();
    });
}
