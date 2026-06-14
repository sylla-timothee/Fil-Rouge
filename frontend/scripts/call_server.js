const SERV_BASE = window.location.pathname.includes('Fil-Rouge')
    ? '/Fil-Rouge/backend'
    : '/backend';

export const SERV = {
    async request(url, options = {}) {
        const defaults = { 
            credentials: 'include',
            headers: {} 
        };

        if (!(options.body instanceof FormData)) {
            defaults.headers['Content-Type'] = 'application/json';
        }

        
        const token = localStorage.getItem('token'); 
        if (token) {
            defaults.headers['Authorization'] = `Bearer ${token}`;
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
            return SERV.request('/auth/login.php', {
                method: 'POST',
                body: JSON.stringify(data)
            });
        },
        register(data) {
        return SERV.request('/auth/register.php', {
            method: 'POST',
            body: JSON.stringify(data) 
            });
        },
        logout() {
            return SERV.request('/auth/logout.php', { method: 'POST' });
        },
        session() {
            return SERV.request('/auth/session.php?t=' + Date.now());
        }
    },
    account: {
        get_profile() {
            return SERV.request('/account/get_profile.php', {
                method: 'GET',
            })
        }
    },
    properties: {
        getAll() {
            return SERV.request('/properties/get_properties.php', { method: 'GET' });
        },
        create(data) {
            return SERV.request('/properties/post_properties.php', {
                method: 'POST',
                body: JSON.stringify(data)
            });
        },
        getById(id) {
            return SERV.request('/properties/get_property_details.php?id=' + id, {
                method: 'GET',
            })
        },
        delete(id) {
            return SERV.request('/properties/delete_property.php?id=' + id, {
                method: 'DELETE',
            })
        }
    }
};