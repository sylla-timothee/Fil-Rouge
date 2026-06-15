import { SERV } from './call_server.js';

document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");

    if (!id) {
        document.getElementById('message').textContent = "Aucun bien sélectionné.";
        return;
    }

    loadProperty(id);
});

async function loadProperty(id) {
    try {
        const property = await SERV.properties.getById(id);
        render(property);
    } catch (err) {
        document.getElementById('message').textContent = err.message;
    }
}

function render(p) {
    const rdvBtn = document.getElementById('rdvBtn');
    const userId = localStorage.getItem('IdUser');

    if (userId) {
    rdvBtn.style.display = 'block';
    } else {
        rdvBtn.style.display = 'none';
    }
    document.getElementById('message').style.display = 'none';
    document.getElementById('propertyDetail').style.display = 'block';

    document.getElementById('detailTitle').textContent   = p.title;
    document.getElementById('detailId').textContent      = '#' + p.id;
    document.getElementById('detailCity').textContent    = p.city;
    document.getElementById('detailAddress').textContent = p.address;
    document.getElementById('detailSurface').textContent = p.surface + ' m²';
    document.getElementById('detailPrice').textContent   = Number(p.prix).toLocaleString('fr-FR') + ' €';
    document.getElementById('detailType').textContent    = p.type;
    document.getElementById('detailStatus').textContent  = p.status;

    // Image
    if (p.image_url) {
        const img = document.getElementById('detailImage');
        img.src = p.image_url;
        img.alt = p.title;
        img.style.display = 'block';
    } else {
        document.getElementById('noImage').textContent = 'Aucune photo disponible';
    }

    // Agence
    document.getElementById('agencyCity').textContent    = p.agency_city    ?? '—';
    document.getElementById('agencyAddress').textContent = p.agency_address ?? '—';
    document.getElementById('agencyPhone').textContent   = p.agency_phone   ?? '—';

    // Agent
    document.getElementById('agentName').textContent = p.agent_name ?? '—';
}