createdb candydb

psql -d candydb

SET timezone TO 'America/Sao_Paulo';

CREATE TABLE "order" 
(
    id SERIAL PRIMARY KEY, 
    title VARCHAR(255) NOT NULL, 
    client VARCHAR(255) NOT NULL, 
    endDate TIMESTAMP NOT NULL, 
    price NUMERIC(10,2) NOT NULL, 
    paymentMethod VARCHAR(100) NOT NULL, 
    description TEXT, 
    finished BOOLEAN DEFAULT FALSE, 
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
