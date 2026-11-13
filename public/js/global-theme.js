// Kegunaan file: Menyimpan dan mengganti pilihan tema terang atau gelap.
const themeToggle = document.querySelector('.smaart-theme-toggle');

if (themeToggle) {
    const root = document.documentElement;

    // Perbarui label aksesibilitas tombol sesuai tema yang sedang dipakai.
    const updateThemeToggle = () => {
        const isDark = root.classList.contains('smaart-dark-mode');
        const label = isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';

        themeToggle.setAttribute('aria-label', label);
        themeToggle.setAttribute('aria-pressed', String(isDark));
        themeToggle.setAttribute('title', label);
    };

    updateThemeToggle();

    // Ganti tema dan simpan pilihan pengunjung di browser.
    themeToggle.addEventListener('click', () => {
        const isDark = root.classList.toggle('smaart-dark-mode');
        const theme = isDark ? 'dark' : 'light';

        updateThemeToggle();

        try {
            window.localStorage.setItem('smaart-theme', theme);
        } catch (error) {
            console.warn('Unable to save the SMAART theme preference.', error);
        }
    });
}
