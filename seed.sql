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
('Emma', 'Petit', '$2y$10$examplehash4', 'emma.petit@example.com', 'client'),
('Bob', 'Dylan', '$2y$10$examplehash5', 'bob.dylan@exemple.com', 'admin');

-- PROPERTIES
INSERT INTO properties
(agency_id, agent_id, title, city, surface, address, prix, type, status)
VALUES
(1, 1, 'Appartement moderne proche centre', 'Paris', 65, '12 Rue Lafayette', 420000, 'Résidentiel', 'Disponible'),

(1, 1, 'Studio étudiant rénové', 'Paris', 25, '8 Rue Mouffetard', 185000, 'Résidentiel', 'En Attente'),

(2, 2, 'Maison familiale avec jardin', 'Lyon', 145, '18 Avenue des Frères Lumière', 620000, 'Résidentiel', 'Disponible'),

(2, 2, 'Bureau open-space', 'Lyon', 210, '55 Rue de la République', 890000, 'professional', 'Disponible'),

(3, 1, 'Villa avec piscine', 'Marseille', 220, '45 Avenue du Prado', 980000, 'Résidentiel', 'vendu'),

(3, 2, 'Local commercial centre-ville', 'Marseille', 120, '10 Rue Saint-Ferréol', 450000, 'professional', 'En Attente'),

(2, 1, 'Appartement T3 lumineux', 'Villeurbanne', 78, '22 Rue Anatole France', 295000, 'Résidentiel', 'Disponible'),

(1, 2, 'Loft industriel rénové', 'Paris', 110, '5 Rue Oberkampf', 750000, 'Résidentiel', 'vendu');

-- PROPERTY IMAGES
INSERT INTO properties_images (property_id, url, sort_order) VALUES
-- Appartement moderne Paris
(1, 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200', 1),
(1, 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1200', 2),

-- Studio étudiant Paris
(2, 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200', 1),

-- Maison familiale Lyon
(3, 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1200', 1),
(3, 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=1200', 2),

-- Bureau open-space Lyon
(4, 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200', 1),

-- Villa avec piscine Marseille
(5, 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1200', 1),
(5, 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200', 2),

-- Local commercial Marseille
(6, 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200', 1),

-- Appartement T3 Villeurbanne
(7, 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1200', 1),

-- Loft industriel Paris
(8, 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=1200', 1),
(8, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=1200', 2);