// /public/js/language.js
/**
 * Source attribution:
 * - Original portfolio codebase derived from https://tombomeke.com (author: Tom Dekoning).
 * - This Laravel project contains modifications/additions for the Backend Web course.
 */

/**
 * ============================================
 * LANGUAGE SWITCHER
 * ============================================
 * Handles client-side language switching with localStorage
 * and dynamic content updates without page reload
 */

class LanguageSwitcher {
    constructor() {
        this.currentLang = this.getInitialLanguage();
        this.translations = {};
        this.init();
    }

    /**
     * Initialize language switcher
     */
    init() {
        // Load translations from PHP
        this.loadTranslations();

        // Set up toggle button
        this.setupToggleButton();

        // Apply current language
        this.applyLanguage(this.currentLang);
    }

    /**
     * Load translations from PHP (embedded in page)
     */
    loadTranslations() {
        // Translations can be embedded as application/json for editor compatibility
        const el = document.getElementById('portfolio-translations');
        if (el?.textContent) {
            try {
                this.translations = JSON.parse(el.textContent);
                return;
            } catch {
                // ignore and fall back
            }
        }

        // Backward compatible fallback (older layout)
        if (window.portfolioTranslations) {
            this.translations = window.portfolioTranslations;
        }
    }

    /**
     * Get stored language from localStorage
     */
    getStoredLanguage() {
        return localStorage.getItem('portfolio_lang');
    }

    /**
     * Get initial language
     */
    getInitialLanguage() {
        // 1) Backend-provided preference (logged in)
        const userPref = document.documentElement?.dataset?.preferredLanguage;
        if (userPref === 'nl' || userPref === 'en') return userPref;

        // 2) URL param
        try {
            const url = new URL(window.location.href);
            const langParam = url.searchParams.get('lang');
            if (langParam === 'nl' || langParam === 'en') return langParam;
        } catch {
            // ignore
        }

        // 3) Cookie set by this app
        try {
            const match = document.cookie.match(/(?:^|; )portfolio_lang=([^;]+)/);
            const cookieLang = match ? decodeURIComponent(match[1]) : null;
            if (cookieLang === 'nl' || cookieLang === 'en') return cookieLang;
        } catch {
            // ignore
        }

        // 4) Local storage
        const stored = this.getStoredLanguage();
        if (stored === 'nl' || stored === 'en') return stored;

        // 5) Default
        return 'nl';
    }

    /**
     * Store language preference
     */
    storeLanguage(lang) {
        localStorage.setItem('portfolio_lang', lang);
        // Also set cookie for PHP (explicit SameSite makes it more reliable)
        document.cookie = `portfolio_lang=${lang}; path=/; max-age=${365*24*60*60}; SameSite=Lax`;
    }

    /**
     * Setup language toggle button
     */
    setupToggleButton() {
        const toggleBtn = document.getElementById('lang-toggle');
        if (!toggleBtn) return;

        // Set initial button state
        this.updateToggleButton(toggleBtn);

        // Add click event
        toggleBtn.addEventListener('click', () => {
            const newLang = this.currentLang === 'nl' ? 'en' : 'nl';
            this.switchLanguage(newLang);
        });
    }

    /**
     * Update toggle button appearance
     */
    updateToggleButton(btn) {
        const flag = this.currentLang === 'nl' ? '🇳🇱' : '🇬🇧';
        const text = this.currentLang === 'nl' ? 'NL' : 'EN';
        btn.innerHTML = `<span class="flag">${flag}</span> ${text}`;
        btn.setAttribute('data-lang', this.currentLang);
        btn.setAttribute('title', `Switch to ${this.currentLang === 'nl' ? 'English' : 'Nederlands'}`);
    }

    /**
     * Switch to a different language
     */
    switchLanguage(lang) {
        if (lang === this.currentLang) return;

        this.currentLang = lang;
        this.storeLanguage(lang);

        // For authenticated users: sync with backend preference, then reload
        // For guests: just reload with the cookie set
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (csrfToken) {
            // Authenticated: sync with backend first, then reload
            this.syncLanguageWithBackend(lang).then(() => {
                window.location.reload();
            });
        } else {
            // Guest: just reload (cookie is already set)
            window.location.reload();
        }
    }

    /**
     * Sync language preference with backend (for logged-in users)
     */
    async syncLanguageWithBackend(lang) {
        // Check if user is authenticated (check for CSRF token)
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) return; // Not authenticated, skip backend sync

        try {
            const response = await fetch('/language/switch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ language: lang }),
            });

            if (!response.ok) {
                console.warn('Failed to sync language with backend');
            }
        } catch (error) {
            // Silently fail - language still works via cookie
            console.warn('Language sync error:', error);
        }
    }

    /**
     * Apply language to all translatable elements
     */
    applyLanguage(lang) {
        // Find all elements with data-translate attribute
        const elements = document.querySelectorAll('[data-translate]');

        elements.forEach(element => {
            const key = element.getAttribute('data-translate');
            const translation = this.translate(key, lang);

            if (translation !== `[${key}]`) {
                // Check if it's an input placeholder
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.placeholder = translation;
                } else {
                    element.textContent = translation;
                }
            }
        });

        // Update form input placeholders separately
        const nameInput = document.querySelector('input[name="name"]');
        const emailInput = document.querySelector('input[name="email"]');
        const messageInput = document.querySelector('textarea[name="message"]');

        if (nameInput) {
            nameInput.placeholder = this.translate('contact_name_placeholder', lang);
        }
        if (emailInput) {
            emailInput.placeholder = this.translate('contact_email_placeholder', lang);
        }
        if (messageInput) {
            messageInput.placeholder = this.translate('contact_message_placeholder', lang);
        }

        // Update document language attribute
        document.documentElement.lang = lang;

        // Refresh project cards (title/description) if present
        this.updateProjectCards(lang);
    }

    /**
     * Update project cards (title/description) based on selected language
     */
    updateProjectCards(lang) {
        document.querySelectorAll('.project-card').forEach(card => {
            const titleEl = card.querySelector('.project-title');
            const descEl = card.querySelector('.project-description');
            if (!titleEl || !descEl) return;

            const title = card.getAttribute(`data-title-${lang}`) || card.getAttribute('data-title-nl') || titleEl.textContent;
            const desc = card.getAttribute(`data-description-${lang}`) || card.getAttribute('data-description-nl') || descEl.textContent;

            titleEl.textContent = title;
            descEl.textContent = desc;
        });
    }

    /**
     * Get translation for a key
     */
    translate(key, lang = null) {
        lang = lang || this.currentLang;

        if (this.translations[lang] && this.translations[lang][key]) {
            return this.translations[lang][key];
        }

        // Fallback to Dutch
        if (this.translations['nl'] && this.translations['nl'][key]) {
            return this.translations['nl'][key];
        }

        return `[${key}]`;
    }

    /**
     * Get current language
     */
    getCurrentLanguage() {
        return this.currentLang;
    }
}

// Initialize when DOM is ready
let languageSwitcher;

function initLanguageSwitcher() {
    languageSwitcher = new LanguageSwitcher();

    // Expose globally for modal system
    window.translate = (key, lang) => languageSwitcher.translate(key, lang);
    window.getCurrentLang = () => languageSwitcher.getCurrentLanguage();
}

// Auto-initialize
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLanguageSwitcher);
} else {
    initLanguageSwitcher();
}
