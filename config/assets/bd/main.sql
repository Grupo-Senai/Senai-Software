-- Active: 1683993986745@@127.0.0.1@3306@biblioteca
use biblioteca;
DROP TRIGGER IF EXISTS delete_agendamento;
DROP TABLE IF EXISTS cancelamentos;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS agendamentos;

CREATE TABLE superusuario (
  id INT(11) NOT NULL AUTO_INCREMENT,
  login VARCHAR(255) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  login VARCHAR(255) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE agendamentos (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  data DATE NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_termino TIME NOT NULL,
  quantidade_alunos INT(11) NOT NULL,
  curso VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE cancelamentos (
  id INT (50) PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  motivo VARCHAR(100) NOT NULL
);

DELIMITER //
CREATE TRIGGER delete_agendamento
AFTER INSERT ON cancelamentos
FOR EACH ROW
BEGIN
  DELETE FROM agendamentos
  WHERE id = NEW.id AND nome = NEW.nome;
END //
DELIMITER ;

INSERT INTO cancelamentos VALUES (1, "Lenon Yuri", "Não haverá aula amanhã.");
show tables;
select * from users;
select * from agendamentos;
select * from cancelamentos;
select * from superusuario;
show triggers;

insert into users (login, senha) VALUES ('usuarioteste', '12345')

