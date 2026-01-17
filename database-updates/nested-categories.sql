-- Add parent_id and image columns to categories table
ALTER TABLE categories 
ADD COLUMN parent_id INT NULL,
ADD COLUMN image VARCHAR(255) NULL,
ADD COLUMN display_order INT DEFAULT 0,
ADD FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE;

-- Update existing categories to support nesting
CREATE INDEX idx_parent_id ON categories(parent_id);
CREATE INDEX idx_display_order ON categories(display_order);

-- Example data: Main categories
INSERT INTO categories (name_en, name_ar, slug, parent_id, image, display_order, status) VALUES
('Kitchen & Dining', 'مطبخ وطعام', 'kitchen-dining', NULL, 'kitchen-dining.jpg', 1, 'active'),
('Home Decor', 'ديكور منزلي', 'home-decor', NULL, 'home-decor.jpg', 2, 'active'),
('Gifts & Souvenirs', 'هدايا وتذكارات', 'gifts-souvenirs', NULL, 'gifts.jpg', 3, 'active');

-- Example data: Sub-categories
INSERT INTO categories (name_en, name_ar, slug, parent_id, display_order, status) VALUES
('Coffee Equipment', 'معدات القهوة', 'coffee-equipment', 1, 1, 'active'),
('Tea Accessories', 'أدوات الشاي', 'tea-accessories', 1, 2, 'active'),
('Cookware', 'أدوات الطبخ', 'cookware', 1, 3, 'active'),
('Traditional Crafts', 'حرف تقليدية', 'traditional-crafts', 2, 1, 'active'),
('Palestinian Art', 'فن فلسطيني', 'palestinian-art', 2, 2, 'active');
