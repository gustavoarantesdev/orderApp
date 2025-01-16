createdb order_app_db

psql -d order_app_db

SET timezone TO 'America/Sao_Paulo';

-- Tabela de usuários do sistema.
CREATE TABLE users (
    id            SERIAL       PRIMARY KEY,
    name          VARCHAR(150) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash TEXT         NOT NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de clientes.
CREATE TABLE customers (
    id          SERIAL       PRIMARY KEY,
    user_id     INT          NOT NULL,
    name        VARCHAR(150) NOT NULL,
    person_type CHAR(2)      NOT NULL, -- PF para pessoa Física e PJ para Jurídica.
    cpf         VARCHAR(11)  DEFAULT NULL,
    cnpj        VARCHAR(14)  DEFAULT NULL,
    phone       VARCHAR(12)  NOT NULL,
    gender      CHAR(1)      DEFAULT NULL, -- F feminino e M masculino.
    birth_date  DATE         DEFAULT NULL,
    address     VARCHAR(255) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de produtos.
CREATE TABLE products (
    id          SERIAL         PRIMARY KEY,
    user_id     INT            NOT NULL,
    name        VARCHAR(150)   NOT NULL,
    sell_price  NUMERIC(10, 2) NOT NULL,
    cost_price  NUMERIC(10, 2) NOT NULL,
    status      BOOLEAN        DEFAULT TRUE, -- ativo ou desativo para venda.
    description VARCHAR(255)   DEFAULT NULL,
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP
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