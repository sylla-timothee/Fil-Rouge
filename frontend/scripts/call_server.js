const SERV_BASE = '/fil rouge/backend';

const SERV = {
    async request(url, options = {}) {
        const defaults = { credentials: 'include' };
        if (!(options.body instanceof FormData)) {
            defaults.headers = { 'Content-Type': 'application/json' };
        }
        const config = { ...defaults, ...options };
        if (options.headers && defaults.headers) {
            config.headers = { ...defaults.headers, ...options.headers };
        }
        const response = await fetch(SERV_BASE + url, config);
        const data = await response.json();
        if (!response.ok) {
            const error = new Error(data.error || 'Erreur serveur');
            error.status = response.status;
            error.data = data;
            throw error;
        }
        return data;
    },

    auth: {
        login(data) {
            return SERV.request('/auth/login', {
                method: 'POST',
                body: JSON.stringify(data)
            });
        },
        register(formData) {
            return SERV.request('/auth/register', {
                method: 'POST',
                body: formData
            });
        },
        logout() {
            return SERV.request('/auth/logout', { method: 'POST' });
        },
        session() {
            return SERV.request('/auth/session');
        }
    },
}