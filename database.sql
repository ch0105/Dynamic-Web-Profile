CREATE DATABASE profile_db;

USE profile_db;

-- Membuat tabel gallery, saya juga membuat halaman galery menjadi dinamis sebagai percobaan
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    title VARCHAR(255),
    description VARCHAR(255)
);

-- Membuat tabel blog
CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    title VARCHAR(255),
    description TEXT,
    link VARCHAR(255)
);

-- Memasukan data awal pada galerry
INSERT INTO gallery (image, title, description) VALUES
('images/image1.jpg', 'Art 1', 'Strength in Serenity'),
('images/image2.jpg', 'Art 2', 'Strength in Serenity'),
('images/image3.jpg', 'Art 3', 'Wisdom and Maturity'),
('images/image4.jpg', 'Art 4', 'Wisdom and Maturity');

-- Memasukan data awal pada blog
INSERT INTO blog (id, image, title, description, link) VALUES
(1, 'images/ai.png', 'What is Artificial Intelligence (AI)? - IBM', 'Artificial intelligence, or AI, is technology that enables computers and machines to simulate human intelligence and problem-solving capabilities.', 'https://www.ibm.com/topics/artificial-intelligence'),
(2, 'images/supercom.png', 'What Is Supercomputing? - IBM', 'Supercomputing is a form of high-performance computing that determines or calculates by using a powerful computer, a supercomputer, reducing overall time to solution.', 'https://www.ibm.com/topics/supercomputing'),
(3, 'images/neuralink.png', 'Neuralink', 'Create a generalized brain interface to restore autonomy to those with unmet medical needs today and unlock human potential tomorrow.', 'https://neuralink.com/'),
(4, 'images/mc.png', 'Machine Learning', 'Machine learning (ML) is a branch of artificial intelligence (AI) and computer science that focuses on the using data and algorithms to enable AI to imitate the way that humans learn, gradually improving its accuracy.', 'https://www.ibm.com/topics/machine-learning');
  


