createdb order_app_db

psql -d order_app_db

SET timezone TO 'America/Sao_Paulo';

CREATE TABLE users (
    user_id            SERIAL PRIMARY KEY,
    user_name          VARCHAR(150) NOT NULL,
    user_email         VARCHAR(150) NOT NULL UNIQUE,
    user_password_hash TEXT         NOT NULL,
    user_created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    order_id                   SERIAL        PRIMARY KEY,
    user_id                    INTEGER       NOT NULL,
    order_title                VARCHAR(150)  NOT NULL,
    order_quantity             SMALLINT      NOT NULL,
    order_client_name          VARCHAR(150)  NOT NULL,
    order_withdraw             BOOLEAN       DEFAULT FALSE,
    order_completion_date      DATE          NOT NULL,
    order_completion_time      TIME          NOT NULL,
    order_delivery_address     VARCHAR(150)  NOT NULL,
    order_price                NUMERIC(10,2) NOT NULL,
    order_payment_method       SMALLINT      NOT NULL,
    order_payment_installments SMALLINT      NOT NULL,
    order_description          TEXT,
    order_completed            BOOLEAN       DEFAULT FALSE,
    order_created_at           TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);