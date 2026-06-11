import { SERV } from './call_server.js';

let allProperties = [];
let filteredProperties = [];

const filters = {
    date: "",
    price: "",
    surface: "",
    city: "",
    type: ""
};

document.getElementById('sortDate').addEventListener('change', (e) => {
    filters.date = e.target.value;
    applyFilters();
});

document.getElementById('sortPrice').addEventListener('change', (e) => {
    filters.price = e.target.value;
    applyFilters();
});

document.getElementById('sortSurface').addEventListener('change', (e) => {
    filters.surface = e.target.value;
    applyFilters();
});

document.getElementById('cityFilter').addEventListener('change', (e) => {
    filters.city = e.target.value;
    applyFilters();
});

document.getElementById('typeFilter').addEventListener('change', (e) => {
    filters.type = e.target.value;
    applyFilters();
});

function applyFilters() {
    let result = [...allProperties];

    if (filters.city) {
        result = result.filter(p => p.city === filters.city);
    }

    if (filters.type) {
        result = result.filter(p => p.type === filters.type);
    }

    if (filters.price === "asc") {
        result.sort((a, b) => a.prix - b.prix);
    }
    if (filters.price === "desc") {
        result.sort((a, b) => b.prix - a.prix);
    }

    if (filters.surface === "asc") {
        result.sort((a, b) => a.surface - b.surface);
    }
    if (filters.surface === "desc") {
        result.sort((a, b) => b.surface - a.surface);
    }

    if (filters.date === "newest") {
        result.sort((a, b) => b.id - a.id);
    }
    if (filters.date === "oldest") {
        result.sort((a, b) => a.id - b.id);
    }

    filteredProperties = result;
    renderProperties(result);
}

document.addEventListener("DOMContentLoaded", function () {
    loadProperties();
    document.getElementById('addPropertyForm').addEventListener('submit', handleSubmit);
});

async function loadProperties() {
    try {
        const properties = await SERV.properties.getAll();

        allProperties = properties;
        filteredProperties = [...properties];

        renderProperties(filteredProperties);
        setupCityFilter(properties);

    } catch (error) {
        document.getElementById('message').textContent = error.message;
    }
}

function renderProperties(properties) {
    const container = document.getElementById('propertiesContainer');
    const table = document.getElementById('propertiesTable');
    const message = document.getElementById('message');

    if (properties.length === 0) {
        message.textContent = "Aucune propriété trouvée";
        table.style.display = "none";
        return;
    }

    message.style.display = "none";
    table.style.display = "table";
    container.innerHTML = '';

    properties.forEach(property => {
        container.innerHTML += `
        <tr>
            <td>${property.title}</td>
            <td>${property.city}</td>
            <td>${property.surface}</td>
            <td>${property.address}</td>
            <td>${property.prix}</td>
            <td>${property.type}</td>
            <td>${property.status}</td>
        </tr>`;
    });
}

function setupCityFilter(properties) {
    const select = document.getElementById('cityFilter');

    const cities = [...new Set(properties.map(p => p.city))];

    cities.forEach(city => {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        select.appendChild(option);
    });
}

async function handleSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const message = document.getElementById('formMessage');

    const data = {
        title     : form.title.value,
        city      : form.city.value,
        surface   : form.surface.value,
        address   : form.address.value,
        prix      : form.prix.value,
        agency_id : form.agency_id.value,
        agent_id  : form.agent_id.value,
        type      : form.type.value,
        status    : form.status.value
    };

    try {
        const result = await SERV.properties.create(data)
        message.textContent = result.message;
        message.style.color = 'green'
        form.reset()
        loadProperties();
    } catch (error) {
        message.textContent = error.message;
        message.style.color = 'red'
    }
}