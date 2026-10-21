DELETE FROM categories WHERE id IN (1, 2, 3, 4);
INSERT INTO categories (id, name, url, free_paid, tk, image, active, `rank`, created_at, updated_at) VALUES
(1, 'Web & Software Development', 'web-software-development', 'free', '0', 'frontend/assets/images/category/image/software.jpg', 1, 1, NOW(), NOW()),
(2, 'Business & Entrepreneurship', 'business-entrepreneurship', 'free', '0', 'frontend/assets/images/category/image/finance.jpg', 1, 2, NOW(), NOW()),
(3, 'Graphic & UI/UX Design', 'graphic-ui-ux-design', 'free', '0', 'frontend/assets/images/category/image/graphic-design.jpg', 1, 3, NOW(), NOW()),
(4, 'Digital Marketing & Sales', 'digital-marketing-sales', 'free', '0', 'frontend/assets/images/category/image/sales.jpg', 1, 4, NOW(), NOW());

DELETE FROM exams WHERE id IN (1, 2, 3, 4, 5, 6, 7, 8);
INSERT INTO exams (id, catID, mcq_written, free_paid, tk, exam_name, type, startDate, examTime, active, created_at, updated_at) VALUES
(1, 1, 'mcq', 'free', 0, 'Full Stack Web Fundamentals', 'general', '2026-03-01', '30 min', 1, NOW(), NOW()),
(2, 1, 'mcq', 'free', 0, 'PHP & Laravel Core Concepts', 'general', '2026-03-01', '45 min', 1, NOW(), NOW()),
(3, 2, 'mcq', 'free', 0, 'Startup Business Model Assessment', 'general', '2026-03-01', '30 min', 1, NOW(), NOW()),
(4, 2, 'mcq', 'free', 0, 'Financial Planning for Entrepreneurs', 'general', '2026-03-01', '40 min', 1, NOW(), NOW()),
(5, 3, 'mcq', 'free', 0, 'UI/UX Design Principles & Prototyping', 'general', '2026-03-01', '30 min', 1, NOW(), NOW()),
(6, 3, 'mcq', 'free', 0, 'Branding & Visual Identity Test', 'general', '2026-03-01', '35 min', 1, NOW(), NOW()),
(7, 4, 'mcq', 'free', 0, 'Social Media & Search Engine Marketing', 'general', '2026-03-01', '30 min', 1, NOW(), NOW()),
(8, 4, 'mcq', 'free', 0, 'E-Commerce Growth Strategies', 'general', '2026-03-01', '30 min', 1, NOW(), NOW());

DELETE FROM teachers WHERE id IN (1, 2, 3, 4);
INSERT INTO teachers (id, name, subject, job_title, image, active, created_at, updated_at) VALUES
(1, 'Dr. Ahsan Habib', 'Business Development', 'Senior Consultant & Entrepreneur', 'frontend/assets/images/team/team-01.jpg', 1, NOW(), NOW()),
(2, 'Sarah Rahman', 'UI/UX & Product Design', 'Lead Product Designer', 'frontend/assets/images/team/team-02.jpg', 1, NOW(), NOW()),
(3, 'Tanvir Ahmed', 'Full-Stack Engineering', 'Senior Software Architect', 'frontend/assets/images/team/team-03.jpg', 1, NOW(), NOW()),
(4, 'Farhana Yasmin', 'International Trade', 'Export & Import Specialist', 'frontend/assets/images/team/team-04.jpg', 1, NOW(), NOW());
