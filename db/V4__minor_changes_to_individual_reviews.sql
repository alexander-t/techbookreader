UPDATE reviews SET title = 'Refactoring: Improving the Design of Existing Code' where title='Refactoring';
UPDATE reviews SET summary=null WHERE title LIKE 'Professional Scrum Development%';
