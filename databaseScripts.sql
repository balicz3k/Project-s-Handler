create sequence users_user_id_seq;

alter sequence users_user_id_seq owner to jbalicki;

create type task_status as enum ('not_started', 'in_progress', 'done');

alter type task_status owner to jbalicki;

create table users
(
    user_id  integer     default nextval('users_user_id_seq'::regclass) not null
        constraint user_id
            primary key,
    nickname varchar(200)                                               not null,
    email    varchar(300)                                               not null,
    password varchar(255)                                               not null,
    role     varchar(10) default 'user'::character varying              not null
        constraint users_role_check
            check ((role)::text = ANY ((ARRAY ['user'::character varying, 'admin'::character varying])::text[]))
);

alter table users
    owner to jbalicki;

create table personal_data
(
    user_id      integer      not null
        primary key
        constraint fk_user
            references users
            on delete cascade,
    first_name   varchar(100) not null,
    last_name    varchar(100) not null,
    gender       varchar(10)  not null
        constraint personal_data_gender_check
            check ((gender)::text = ANY
        ((ARRAY ['male'::character varying, 'female'::character varying, 'other'::character varying])::text[])),
    phone_number varchar(15)  not null,
    birth_date   date         not null
);

alter table personal_data
    owner to jbalicki;

create table projects
(
    id             serial
        primary key,
    title          varchar(255) not null,
    description    text         not null,
    image          varchar(255) not null,
    created_at     date         not null,
    id_assigned_by integer      not null
        references users
);

alter table projects
    owner to jbalicki;

create table tasks
(
    id         serial
        primary key,
    project_id integer      not null
        references projects,
    title      varchar(255) not null,
    color      varchar(7)   not null,
    status     task_status default 'not_started'::task_status
);

alter table tasks
    owner to jbalicki;

create procedure delete_tasks_by_project(IN p_project_id integer)
    language plpgsql
as
$$
BEGIN
DELETE FROM tasks WHERE project_id = p_project_id;
END;
$$;

alter procedure delete_tasks_by_project(integer) owner to jbalicki;

create procedure delete_projects_by_user(IN p_user_id integer)
    language plpgsql
as
$$
BEGIN
DELETE FROM projects WHERE id_assigned_by = p_user_id;
END;
$$;

alter procedure delete_projects_by_user(integer) owner to jbalicki;

create function trigger_delete_tasks() returns trigger
    language plpgsql
as
$$
BEGIN
    PERFORM delete_tasks_by_project(OLD.id);
RETURN OLD;
END;
$$;

alter function trigger_delete_tasks() owner to jbalicki;

create function trigger_delete_projects() returns trigger
    language plpgsql
as
$$
BEGIN
    PERFORM delete_projects_by_user(OLD.id);
RETURN OLD;
END;
$$;

alter function trigger_delete_projects() owner to jbalicki;

create function delete_user_projects() returns trigger
    language plpgsql
as
$$
DECLARE
project_id INTEGER;
BEGIN
FOR project_id IN SELECT id FROM projects WHERE id_assigned_by = OLD.user_id LOOP
        CALL delete_tasks_by_project(project_id);
END LOOP;
DELETE FROM projects WHERE id_assigned_by = OLD.user_id;
RETURN OLD;
END;
$$;

alter function delete_user_projects() owner to jbalicki;

create procedure removeprojectscreatedbyuser(IN p_user_id integer)
    language plpgsql
as
$$
BEGIN
DELETE FROM projects WHERE id_assigned_by = p_user_id;
END;
$$;

alter procedure removeprojectscreatedbyuser(integer) owner to jbalicki;

create procedure removetasksbyprojectid(IN p_project_id integer)
    language plpgsql
as
$$
BEGIN
DELETE FROM tasks WHERE project_id = p_project_id;
END;
$$;

alter procedure removetasksbyprojectid(integer) owner to jbalicki;

create function before_remove_user() returns trigger
    language plpgsql
as
$$
BEGIN
CALL removeProjectsCreatedByUser(OLD.user_id);
RETURN OLD;
END;
$$;

alter function before_remove_user() owner to jbalicki;

create trigger beforeremoveuser
    before delete
    on users
    for each row
    execute procedure before_remove_user();

create function before_remove_project() returns trigger
    language plpgsql
as
$$
BEGIN
CALL removeTasksByProjectId(OLD.id);
RETURN OLD;
END;
$$;

alter function before_remove_project() owner to jbalicki;

create trigger beforeremoveproject
    before delete
    on projects
    for each row
    execute procedure before_remove_project();
