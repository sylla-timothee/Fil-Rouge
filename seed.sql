-- AGENCIES
INSERT INTO agencies (city, address, phone) VALUES
('Paris', '15 Rue de Rivoli, Paris', '01 42 00 00 01'),
('Lyon', '8 Place Bellecour, Lyon', '04 72 00 00 02'),
('Marseille', '22 Avenue du Prado, Marseille', '04 91 00 00 03');

-- USERS
INSERT INTO users (first_name, last_name, password, email, role) VALUES
('Jean', 'Dupont', '$2y$10$examplehash1', 'jean.dupont@example.com', 'agent'),
('Marie', 'Martin', '$2y$10$examplehash2', 'marie.martin@example.com', 'agent'),
('Lucas', 'Bernard', '$2y$10$examplehash3', 'lucas.bernard@example.com', 'client'),
('Emma', 'Petit', '$2y$10$examplehash4', 'emma.petit@example.com', 'client');

-- PROPERTIES
INSERT INTO properties
(agency_id, agent_id, title, city, surface, address, prix, type, status)
VALUES
(1, 1, 'Appartement moderne proche centre', 'Paris', 65, '12 Rue Lafayette', 420000, 'residential', 'available'),

(1, 1, 'Studio étudiant rénové', 'Paris', 25, '8 Rue Mouffetard', 185000, 'residential', 'pending'),

(2, 2, 'Maison familiale avec jardin', 'Lyon', 145, '18 Avenue des Frères Lumière', 620000, 'residential', 'available'),

(2, 2, 'Bureau open-space', 'Lyon', 210, '55 Rue de la République', 890000, 'professional', 'available'),

(3, 1, 'Villa avec piscine', 'Marseille', 220, '45 Avenue du Prado', 980000, 'residential', 'sold'),

(3, 2, 'Local commercial centre-ville', 'Marseille', 120, '10 Rue Saint-Ferréol', 450000, 'professional', 'pending'),

(2, 1, 'Appartement T3 lumineux', 'Villeurbanne', 78, '22 Rue Anatole France', 295000, 'residential', 'available'),

(1, 2, 'Loft industriel rénové', 'Paris', 110, '5 Rue Oberkampf', 750000, 'residential', 'sold');

-- PROPERTY IMAGES
INSERT INTO properties_images (property_id, url, sort_order) VALUES
(1, 'https://picsum.photos/id/1018/1200/800', 1),
(1, 'https://picsum.photos/id/1015/1200/800', 2),

(2, 'https://picsum.photos/id/1025/1200/800', 1),

(3, 'https://picsum.photos/id/1040/1200/800', 1),
(3, 'https://picsum.photos/id/1043/1200/800', 2),

(4, 'https://picsum.photos/id/1050/1200/800', 1),

(5, 'https://picsum.photos/id/1060/1200/800', 1),
(5, 'https://picsum.photos/id/1068/1200/800', 2),

(6, 'https://picsum.photos/id/1070/1200/800', 1),

(7, 'https://picsum.photos/id/1080/1200/800', 1),

(8, 'https://picsum.photos/id/1084/1200/800', 1),
(8, 'https://picsum.photos/id/1082/1200/800', 2);