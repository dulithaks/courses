create table courses
(
    id         bigserial
        primary key,
    title      varchar(255) not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table courses
    owner to postgres;

