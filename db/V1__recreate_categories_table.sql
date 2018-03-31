DROP TABLE categories;

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  label VARCHAR(255) NOT NULL,
  PRIMARY KEY(id)
);

INSERT INTO categories(id, name, label) VALUES (NULL, 'agile', 'Agile');
INSERT INTO categories(id, name, label) VALUES (NULL, 'product_ownership', 'Product Ownership & Requirements');
INSERT INTO categories(id, name, label) VALUES (NULL, 'architecture', 'Architecture');
INSERT INTO categories(id, name, label) VALUES (NULL, 'continuous_delivery', 'Continuous Delivery');
INSERT INTO categories(id, name, label) VALUES (NULL, 'sw_engineering', 'Software Engineering');
INSERT INTO categories(id, name, label) VALUES (NULL, 'testing', 'TDD and Testing');
INSERT INTO categories(id, name, label) VALUES (NULL, 'code', 'Working with Code');
INSERT INTO categories(id, name, label) VALUES (NULL, 'databases', 'Databases');
INSERT INTO categories(id, name, label) VALUES (NULL, 'tools', 'Tools');
INSERT INTO categories(id, name, label) VALUES (NULL, 'cloud', 'The Cloud');
INSERT INTO categories(id, name, label) VALUES (NULL, 'web', 'Web Development');
INSERT INTO categories(id, name, label) VALUES (NULL, 'microsoft', 'Microsoft');
INSERT INTO categories(id, name, label) VALUES (NULL, 'security', 'Security');
INSERT INTO categories(id, name, label) VALUES (NULL, 'performance', 'Performance');
INSERT INTO categories(id, name, label) VALUES (NULL, 'java', 'Java and J2EE');
INSERT INTO categories(id, name, label) VALUES (NULL, 'javascript', 'JavaScript');
INSERT INTO categories(id, name, label) VALUES (NULL, 'ruby', 'Ruby');
INSERT INTO categories(id, name, label) VALUES (NULL, 'dotnet', '.NET');
INSERT INTO categories(id, name, label) VALUES (NULL, 'exam_prep', 'Exam Preparation');
INSERT INTO categories(id, name, label) VALUES (NULL, 'game_development', 'Game Development');
INSERT INTO categories(id, name, label) VALUES (NULL, 'tech_other', 'Novels & Other');
INSERT INTO categories(id, name, label) VALUES (NULL, 'leadership', 'Leadership');

