create table results
(
    id         bigserial
        primary key,
    user_id    bigint   not null
        constraint results_user_id_foreign
            references users,
    course_id  bigint   not null
        constraint results_course_id_foreign
            references courses,
    status     smallint not null,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table results
    owner to postgres;

