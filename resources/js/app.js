// Kegunaan file: Mengatur interaksi halaman seperti menu, konsultasi, dan navigasi.
import './bootstrap';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// Pilihan layanan dari kartu pilar otomatis mengisi layanan di formulir.
document.querySelectorAll('[data-consultation-service]').forEach((link) => {
    link.addEventListener('click', () => {
        const serviceField = document.querySelector('#inquiry-topic');
        if (serviceField) {
            serviceField.value = link.dataset.consultationService;
        }
    });
});

// Tandai menu navigasi yang sesuai dengan bagian halaman yang sedang dibuka.
const setActiveNav = () => {
    const sections = document.querySelectorAll('main section[id]');
    const navLinks = document.querySelectorAll('.main-nav a');
    const scrollPosition = window.scrollY + 180;

    sections.forEach((section) => {
        const id = section.getAttribute('id');
        const top = section.offsetTop;
        const bottom = top + section.offsetHeight;

        if (scrollPosition >= top && scrollPosition < bottom) {
            navLinks.forEach((link) => {
                link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
            });
        }
    });
};

const navToggle = document.querySelector('.nav-toggle');
const navMenu = document.querySelector('.main-nav');

// Atur buka/tutup menu, navigasi halus, dan dukungan tombol Escape.
if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
        const isOpen = navMenu.classList.toggle('is-open');
        navToggle.setAttribute('aria-expanded', String(isOpen));
        navToggle.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
    });

    const closeNav = () => {
        navMenu.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.setAttribute('aria-label', 'Buka menu navigasi');
    };

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            if (navMenu.contains(link)) {
                closeNav();
            }

            if (
                event.defaultPrevented
                || event.button !== 0
                || event.metaKey
                || event.ctrlKey
                || event.shiftKey
                || event.altKey
                || !link.hash
            ) {
                return;
            }

            const target = document.getElementById(decodeURIComponent(link.hash.slice(1)));
            if (!target) {
                return;
            }

            event.preventDefault();

            const heading = target.querySelector(
                '.home-hero h1, .home-section-heading h2, .home-about-copy h2, .home-contact-copy h2'
            );
            const destination = heading || target;
            const headerHeight = document.querySelector('.site-header')?.getBoundingClientRect().height || 0;
            const top = Math.max(
                0,
                window.scrollY + destination.getBoundingClientRect().top - headerHeight - 16
            );

            if (window.location.hash !== link.hash) {
                window.history.pushState(null, '', link.hash);
            }

            window.scrollTo({ top, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && navMenu.classList.contains('is-open')) {
            closeNav();
            navToggle.focus();
        }
    });
}

// Perbarui header, tombol kembali ke atas, dan menu saat halaman digulir.
const handleScrollState = () => {
    const scrolled = window.scrollY > 18;
    document.body.classList.toggle('scrolled', scrolled);

    const backToTop = document.querySelector('.back-to-top');
    if (backToTop) {
        backToTop.classList.toggle('visible', window.scrollY > 460);
    }

    setActiveNav();
}; 


window.addEventListener('scroll', handleScrollState, { passive: true });
handleScrollState();

const revealItems = document.querySelectorAll('.reveal');
// Tampilkan elemen saat masuk layar, kecuali pengguna memilih gerakan minimal.
if (!reduceMotion && revealItems.length) {
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.18 });

    revealItems.forEach((item) => revealObserver.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

const backToTop = document.querySelector('.back-to-top');
// Gulir kembali ke awal halaman saat tombol ditekan.
if (backToTop) {
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
    });
}

const productDialog = document.getElementById('home-product-dialog');
const productDialogImage = productDialog?.querySelector('.home-product-dialog-image');
const productDialogContact = document.getElementById('home-product-dialog-contact');
const contactSection = document.getElementById('contact');
const contactPanel = document.querySelector('.home-consultation');
const inquiryHeading = document.getElementById('consultation-heading');
const inquiryIntro = document.getElementById('consultation-intro');
const inquiryName = document.getElementById('consultation-name');
let inquiryHighlightTimeout;

// Siapkan formulir konsultasi dengan nama produk yang dipilih pengunjung.
const openProductInquiry = (product) => {
    if (!product || !contactSection || !contactPanel) {
        return;
    }

    const topic = document.getElementById('inquiry-topic');
    const message = document.getElementById('message');

    if (topic) {
        topic.value = 'Produk SMAART';
    }
    if (message) {
        message.value = `Saya ingin mengetahui lebih lanjut tentang ${product}. `;
    }
    if (inquiryHeading) {
        inquiryHeading.textContent = `Tanya tentang ${product}`;
    }
    if (inquiryIntro) {
        inquiryIntro.textContent = 'Lengkapi data dan ceritakan informasi yang ingin Anda ketahui. Tim SMAART akan menghubungi Anda.';
    }

    if (window.location.hash !== '#contact') {
        window.history.pushState(null, '', '#contact');
    }

    const headerHeight = document.querySelector('.site-header')?.getBoundingClientRect().height || 0;
    const top = Math.max(
        0,
        window.scrollY + contactPanel.getBoundingClientRect().top - headerHeight - 16
    );
    window.scrollTo({ top, behavior: reduceMotion ? 'auto' : 'smooth' });

    contactPanel.classList.add('is-product-inquiry');
    window.clearTimeout(inquiryHighlightTimeout);
    inquiryHighlightTimeout = window.setTimeout(() => {
        contactPanel.classList.remove('is-product-inquiry');
    }, 1800);

    window.setTimeout(() => inquiryName?.focus({ preventScroll: true }), reduceMotion ? 0 : 450);
};

// Tampilkan detail produk dalam dialog.
document.querySelectorAll('[data-product-details]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!productDialog || !productDialogImage || !productDialogContact) {
            return;
        }

        const { name, tagline, description, image } = button.dataset;
        document.getElementById('home-product-dialog-title').textContent = name || '';
        document.getElementById('home-product-dialog-tagline').textContent = tagline || '';
        document.getElementById('home-product-dialog-description').textContent = description || '';
        productDialogImage.src = image || '';
        productDialogImage.alt = name || '';
        productDialogContact.dataset.product = name || '';
        productDialog.showModal();
    });
});

const productDialogClose = productDialog?.querySelector('.home-product-dialog-close');
productDialogClose?.addEventListener('click', () => productDialog.close());
productDialog?.addEventListener('click', (event) => {
    if (event.target === productDialog) {
        productDialog.close();
    }
});

document.querySelectorAll('[data-product]').forEach((link) => {
    link.addEventListener('click', () => {
        const product = link.getAttribute('data-product');
        if (productDialog?.open && productDialog.contains(link)) {
            productDialog.close();
        }
        openProductInquiry(product);
    });
});

// Ganti gambar produk bergantian dan hentikan saat pengunjung tidak melihatnya.
document.querySelectorAll('.home-product-slideshow').forEach((slideshow) => {
    const slides = [...slideshow.querySelectorAll('img')];
    let activeSlide = 0;
    let slideTimer;
    const showNextSlide = () => {
        activeSlide = (activeSlide + 1) % slides.length;
        slides.forEach((slide, index) => {
            slide.classList.toggle('is-active', index === activeSlide);
        });
    };
    const startSlideshow = () => {
        if (reduceMotion || document.hidden || slideTimer || slides.length < 2) {
            return;
        }

        slideTimer = window.setInterval(showNextSlide, 4500);
    };
    const stopSlideshow = () => {
        window.clearInterval(slideTimer);
        slideTimer = undefined;
    };

    slideshow.addEventListener('mouseenter', stopSlideshow);
    slideshow.addEventListener('mouseleave', startSlideshow);
    slideshow.addEventListener('focusin', stopSlideshow);
    slideshow.addEventListener('focusout', startSlideshow);
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopSlideshow();
        } else {
            startSlideshow();
        }
    });
    startSlideshow();
});

const chatPanel = document.querySelector('.chatbot-panel');
const chatToggle = document.querySelector('.chatbot-toggle');
const chatClose = document.querySelector('.chatbot-close');
const chatBody = document.getElementById('chatbot-body');
const chatInput = document.getElementById('chatbot-input');
const chatSend = document.querySelector('.chatbot-send');
const chatReset = document.querySelector('.chatbot-reset');
const chatHandoff = document.querySelector('.chatbot-handoff');
const chatStatus = document.querySelector('.chatbot-conversation-status');
const chatWidget = document.querySelector('.chatbot');
const quickReplies = document.querySelectorAll('.quick-reply');
const chatEndpoint = chatWidget?.dataset.chatEndpoint;
const handoffEndpoint = chatWidget?.dataset.handoffEndpoint;
const chatTokenKey = 'smaart-chat-session';
const renderedMessages = new Set();
let isChatPending = false;
let conversationStatus = 'open';

// Buat ID unik agar riwayat chat pengunjung dapat ditemukan kembali.
const createChatToken = () => {
    if (window.crypto?.randomUUID) {
        return window.crypto.randomUUID();
    }

    const bytes = window.crypto.getRandomValues(new Uint8Array(16));
    bytes[6] = (bytes[6] & 0x0f) | 0x40;
    bytes[8] = (bytes[8] & 0x3f) | 0x80;
    const hex = [...bytes].map((byte) => byte.toString(16).padStart(2, '0')).join('');
    return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${hex.slice(12, 16)}-${hex.slice(16, 20)}-${hex.slice(20)}`;
};

let chatToken;
try {
    chatToken = window.localStorage.getItem(chatTokenKey) || createChatToken();
    window.localStorage.setItem(chatTokenKey, chatToken);
} catch (error) {
    console.warn('Unable to persist the SMAART chat session.', error);
    chatToken = createChatToken();
}

// Tambahkan satu pesan ke tampilan percakapan.
const addMessage = (item) => {
    const message = document.createElement('div');
    message.className = `chat-message ${item.sender_type === 'visitor' ? 'user' : 'bot'}`;
    message.dataset.messageId = String(item.id);

    const textNode = document.createElement('p');
    textNode.textContent = item.message;

    message.appendChild(textNode);
    chatBody.appendChild(message);
    chatBody.scrollTop = chatBody.scrollHeight;
};

// Samakan isi tampilan chat dan status tombol dengan data dari server.
const syncConversation = (data) => {
    data.messages.forEach((message) => {
        const id = String(message.id);
        if (!renderedMessages.has(id)) {
            renderedMessages.add(id);
            addMessage(message);
        }
    });

    conversationStatus = data.status;
    const closed = conversationStatus === 'closed';
    if (chatStatus) {
        chatStatus.textContent = ({
            waiting_admin: 'Menunggu admin bergabung…',
            with_admin: 'Admin sedang menangani percakapan ini.',
            closed: 'Percakapan ditutup. Mulai chat baru untuk mengirim pesan lagi.',
        })[conversationStatus] || 'Asisten otomatis siap membantu.';
    }

    chatInput.disabled = closed;
    chatSend.disabled = closed;
    chatHandoff.disabled = closed || conversationStatus !== 'open';
    chatToggle?.closest('.chatbot')?.classList.toggle('has-conversation', data.messages.length > 0);
};

// Kirim permintaan API JSON dan ubah respons gagal menjadi error yang jelas.
const requestJson = async (url, options = {}) => {
    const response = await fetch(url, {
        ...options,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...options.headers,
        },
    });
    const data = await response.json().catch(() => ({}));

    if (!response.ok) {
        throw new Error(data.message || 'Pesan belum dapat diproses. Silakan coba lagi.');
    }

    return data;
};

// Ambil pesan terbaru untuk sesi chat pengunjung ini.
const refreshConversation = async () => {
    if (!chatEndpoint || chatPanel.hasAttribute('hidden')) {
        return;
    }

    try {
        const url = new URL(chatEndpoint, window.location.href);
        url.searchParams.set('session_token', chatToken);
        syncConversation(await requestJson(url));
    } catch (error) {
        if (chatStatus) {
            chatStatus.textContent = error.message || 'Tidak dapat memuat percakapan.';
        }
    }
};

// Kunci tombol sementara permintaan chat sedang diproses.
const setChatPending = (pending) => {
    isChatPending = pending;
    const closed = conversationStatus === 'closed';
    chatInput.disabled = pending || closed;
    chatSend.disabled = pending || closed;
    chatReset.disabled = pending;
    chatHandoff.disabled = pending || conversationStatus !== 'open';
    quickReplies.forEach((button) => {
        button.disabled = pending || closed;
    });
};

// Tampilkan pesan jika permintaan chat gagal.
const showChatError = (error, fallback) => {
    const status = document.createElement('p');
    status.className = 'chatbot-error';
    status.setAttribute('role', 'alert');
    status.textContent = error.message || fallback;
    chatBody.appendChild(status);
    chatBody.scrollTop = chatBody.scrollHeight;
};

// Kirim pesan pengunjung ke API lalu perbarui isi percakapan.
const sendUserMessage = async (value) => {
    const trimmed = value.trim();
    if (!trimmed || isChatPending) {
        return;
    }

    setChatPending(true);
    try {
        const data = await requestJson(chatEndpoint, {
            method: 'POST',
            body: JSON.stringify({ session_token: chatToken, message: trimmed }),
        });
        syncConversation(data);
    } catch (error) {
        showChatError(error, 'Koneksi bermasalah. Silakan coba lagi.');
    } finally {
        setChatPending(false);
        await refreshConversation();
        if (!chatInput.disabled) {
            chatInput.focus();
        }
    }
};

// Minta admin mengambil alih percakapan dari asisten otomatis.
const requestAdmin = async () => {
    if (!handoffEndpoint || isChatPending) {
        return;
    }

    setChatPending(true);
    try {
        syncConversation(await requestJson(handoffEndpoint, {
            method: 'POST',
            body: JSON.stringify({ session_token: chatToken }),
        }));
    } catch (error) {
        showChatError(error, 'Permintaan bantuan admin gagal dikirim.');
    } finally {
        setChatPending(false);
    }
};

if (chatToggle && chatPanel) {
    chatToggle.addEventListener('click', () => {
        const isHidden = chatPanel.hasAttribute('hidden');
        chatPanel.toggleAttribute('hidden', !isHidden);
        chatToggle.setAttribute('aria-expanded', String(isHidden));
        chatToggle.closest('.chatbot')?.classList.toggle('is-open', isHidden);
        if (isHidden) {
            refreshConversation();
            chatInput.focus();
        }
    });
}

if (chatClose && chatPanel) {
    chatClose.addEventListener('click', () => {
        chatPanel.setAttribute('hidden', 'hidden');
        chatToggle.setAttribute('aria-expanded', 'false');
        chatToggle.closest('.chatbot')?.classList.remove('is-open');
        chatToggle.focus();
    });
}

if (chatSend) {
    chatSend.addEventListener('click', () => {
        sendUserMessage(chatInput.value);
        chatInput.value = '';
        chatInput.style.height = 'auto';
    });
}

if (chatInput) {
    chatInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendUserMessage(chatInput.value);
            chatInput.value = '';
            chatInput.style.height = 'auto';
        }
    });

    chatInput.addEventListener('input', () => {
        chatInput.style.height = 'auto';
        chatInput.style.height = `${Math.min(chatInput.scrollHeight, 128)}px`;
    });
}

if (chatReset) {
    chatReset.addEventListener('click', () => {
        chatToken = createChatToken();
        try {
            window.localStorage.setItem(chatTokenKey, chatToken);
        } catch (error) {
            console.warn('Unable to persist the new SMAART chat session.', error);
        }
        renderedMessages.clear();
        conversationStatus = 'open';
        chatBody.innerHTML = '';
        chatToggle?.closest('.chatbot')?.classList.remove('has-conversation');
        addMessage({
            id: 'welcome',
            sender_type: 'bot',
            message: 'Halo! Saya Asisten SMAART. Saya bisa membantu Anda mengenal layanan, produk, dan menghubungkan Anda dengan tim kami.',
        });
        if (chatStatus) {
            chatStatus.textContent = 'Asisten otomatis siap membantu.';
        }
        setChatPending(false);
        chatInput.value = '';
        chatInput.style.height = 'auto';
        chatInput.focus();
    });
}

quickReplies.forEach((button) => {
    button.addEventListener('click', () => {
        sendUserMessage(button.textContent.trim());
        chatInput.value = '';
    });
});

if (chatHandoff) {
    chatHandoff.addEventListener('click', requestAdmin);
}

window.setInterval(refreshConversation, 3000);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && chatPanel && !chatPanel.hasAttribute('hidden')) {
        chatPanel.setAttribute('hidden', 'hidden');
        chatToggle.setAttribute('aria-expanded', 'false');
        chatToggle.closest('.chatbot')?.classList.remove('is-open');
        chatToggle.focus();
    }
});
