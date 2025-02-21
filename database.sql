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
    created_at  TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de pedidos
CREATE TABLE orders (
    id                   SERIAL        PRIMARY KEY,
    user_id              INTEGER       NOT NULL,
    customer_id          INTEGER       NOT NULL,
    order_number         INTEGER       NOT NULL,
    delivery_address     VARCHAR(150)  NOT NULL,
    additional           NUMERIC(10,2) NOT NULL,
    discount             NUMERIC(10,2) NOT NULL,
    subtotal             NUMERIC(10,2) NOT NULL,
    payment_value        NUMERIC(10,2) NOT NULL,
    payment_status       SMALLINT      NOT NULL,
    payment_method       SMALLINT      NOT NULL,
    payment_installments SMALLINT      NOT NULL,
    payment_date         DATE          NOT NULL,
    completion_date      DATE          NOT NULL,
    completion_time      TIME          NOT NULL,
    withdraw             BOOLEAN       DEFAULT FALSE,
    order_status         SMALLINT      NOT NULL,
    description          VARCHAR(255)  DEFAULT NULL,
    created_at           TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)        REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id)    REFERENCES customers(id) ON DELETE CASCADE
);

-- Tabela de itens do pedido.
CREATE TABLE order_items (
    id          SERIAL         PRIMARY KEY,
    user_id     INTEGER        NOT NULL,
    order_id    INTEGER        NOT NULL,
    product_id  INTEGER        NOT NULL,
    sell_price  NUMERIC(10, 2) NOT NULL,
    quantity    INTEGER        NOT NULL,

    FOREIGN KEY (user_id)    REFERENCES users(id),
    FOREIGN KEY (order_id)   REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);