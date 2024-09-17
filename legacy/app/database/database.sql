createdb candydb

psql -d candydb

SET timezone TO 'America/Sao_Paulo';

CREATE TABLE orders (
    order_id             SERIAL        PRIMARY KEY, 
    order_title          VARCHAR(150)  NOT NULL, 
    client_name          VARCHAR(150)  NOT NULL, 
    completion_date      DATE          NOT NULL,
    completion_time      TIME          NOT NULL,
    order_price          NUMERIC(10,2) NOT NULL, 
    payment_method       VARCHAR(20)   NOT NULL, 
    payment_installments SMALLSERIAL,
    order_description    TEXT, 
    is_completed         BOOLEAN       DEFAULT FALSE, 
    created_at           TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);