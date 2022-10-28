CREATE DATABASE dbassinador;
USE dbassinador;
CREATE TABLE tb_certificados (
	idcertificado  INT NOT NULL AUTO_INCREMENT,
	desnome VARCHAR(100),
    dessenhacertificado VARCHAR(100),
    descaminho VARCHAR(100),
	CONSTRAINT PK_certificados PRIMARY KEY (idcertificado)
) ENGINE = InnoDB;

CREATE TABLE tb_usuarios (
	idusuario  INT NOT NULL AUTO_INCREMENT,
    desusuario VARCHAR(100),
    dessenha VARCHAR(100),
    desnome VARCHAR(100),
    descpf VARCHAR(30),
    idcertificado INT  NOT NULL,
    dtcadastro DATE DEFAULT(current_time()),
CONSTRAINT PK_usuarios PRIMARY KEY (idusuario),
CONSTRAINT FK_usuarios_certificados FOREIGN KEY (idcertificado)
		REFERENCES tb_certificados (idcertificado)
);

CREATE TABLE tb_documentospendentes (
	iddocumento INT NOT NULL AUTO_INCREMENT,
    desnome VARCHAR(100),
    desdescricao VARCHAR(100),
    
);

INSERT INTO tb_certificados (desnome,dessenhacertificado,descaminho) VALUES ("certificado.p12","$2y$10$iHgpM0YdXofeA9TcJKu1oeCl1xk9TtyMdtt7FejG60BtFD1l/da9y","/certificados/86521551000/certificado.p12" );


INSERT INTO tb_usuarios (desusuario,dessenha,desnome,descpf,idcertificado) VALUES ("almansa","$2y$10$qnGd7RDNL046pZoSYfkB/eRKlTEDt5Q3w7XzOls58yttdkh0YpYPO","Gustavo Almansa", "86521551000", "1" );

