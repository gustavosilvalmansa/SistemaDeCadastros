
CREATE TABLE usuarios(
	id INT NOT NULL AUTO_INCREMENT,
    usuario VARCHAR(100),
    senha VARCHAR(100),
    nome_user VARCHAR(100),
    cpf_user VARCHAR(100),
    email_user VARCHAR(100),
    telefone_comercial VARCHAR(100),
    telefone_pessoal VARCHAR(100),
    dados_bancarios VARCHAR(100),
    tipo_login int,
    cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT PK_usuarios PRIMARY KEY (idusuarios)
)ENGINE = InnoDB;

INSERT INTO usuarios (usuario,senha,nome_user,cpf_user,email_user,telefone_comercial,telefone_pessoal,dados_bancarios,tipo_login) 
VALUES ("Almansa","123","Gustavo Almansa", "86521551000","gustavo@email.com","5191088462", "5191088462", "PIX 86521551000", 1);
