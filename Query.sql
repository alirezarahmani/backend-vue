create database IF NOT EXISTS roomvu;
create table users
(
    id        varchar(36)  not null,
    name      varchar(255)           not null,
    credit    int         default 0 null,
    createdAt datetime              not null,
    constraint users_pk
    primary key (id)
);

create table transactions
(
    id        varchar(36) not null,
    amount    int         default 0 null,
    createdAt datetime              not null,
    constraint transactions_pk
        primary key (id)
);

alter table transactions
    add user_id varchar(36) not null after amount;

alter table transactions
    add constraint transactions_users_id_fk
        foreign key (user_id) references users (id);

