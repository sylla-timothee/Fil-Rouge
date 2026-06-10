import { SERV } from './call_server.js';

document.addEventListener("DOMContentLoaded", function () {
    loadProperties();
    document.getElementById('addPropertyForm').addEventListener('submit', handleSubmit);
});

async function loadProperties() {
    try {
        const properties = await SERV.properties.getAll();
        const container = document.getElementById('propertiesContainer');
        const table = document.getElementById('propertiesTable');
        const message = document.getElementById('message');

        if (properties.length==0) {
            message.textContent = "Aucune propriété trouvée"
            return;
        }
        message.style.display = 'none'
        table.style.display = 'table'
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
            </tr>`
        });
    } catch (error) {
        document.getElementById('message').textContent = error.message;
    }
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