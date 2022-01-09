CREATE TABLE IF NOT EXISTS CARRELLO (
  Id_carrello int NOT NULL AUTO_INCREMENT,
  Nome varchar(20) NOT NULL,
  PRIMARY KEY (Id_carrello)
);

CREATE TABLE IF NOT EXISTS CARRELLO_PRODOTTI (
  Id_carrello char(6) NOT NULL,
  Piva char(11) NOT NULL,
  Ean char(13) NOT NULL,
  PRIMARY KEY (Id_carrello,Piva,Ean),
  KEY Piva (Piva),
  KEY Ean (Ean)
);

CREATE TABLE IF NOT EXISTS CARRELLO_UTENTE (
  Id_carrello char(6) NOT NULL,
  Email varchar(50) NOT NULL,
  PRIMARY KEY (Id_carrello,Email),
  KEY Email (Email)
);

CREATE TABLE IF NOT EXISTS LISTA (
  Id_lista int NOT NULL AUTO_INCREMENT,
  Nome varchar(20) NOT NULL,
  PRIMARY KEY (Id_lista)
);

CREATE TABLE IF NOT EXISTS LISTA_PRODOTTI (
  Id_lista char(6) NOT NULL,
  Ean char(13) NOT NULL,
  PRIMARY KEY (Id_lista,Ean),
  KEY Ean (Ean)
);

CREATE TABLE IF NOT EXISTS LISTA_UTENTE (
  Id_lista char(6) NOT NULL,
  Email varchar(50) NOT NULL,
  PRIMARY KEY (Id_lista,Email),
  KEY Email (Email)
);

CREATE TABLE IF NOT EXISTS NODO (
  Numero char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  Piva char(11) NOT NULL,
  X float DEFAULT NULL,
  Y float DEFAULT NULL,
  PRIMARY KEY (Numero,Piva),
  KEY Piva (Piva)
);

CREATE TABLE IF NOT EXISTS PRODOTTO (
  Ean char(13) NOT NULL,
  Nome varchar(100) DEFAULT NULL,
  Descrizione varchar(300) DEFAULT NULL,
  Marchio varchar(50) DEFAULT NULL,
  Categoria varchar(50) DEFAULT NULL,
  Immagine varchar(50) DEFAULT 'nondisponibile.jpg',
  PRIMARY KEY (Ean)
);

CREATE TABLE IF NOT EXISTS SUPERMERCATO (
  Piva char(11) NOT NULL,
  Nome varchar(100) DEFAULT NULL,
  Mappa varchar(50) DEFAULT 'nondisponibile.jpg',
  Immagine varchar(50) DEFAULT 'nondisponibile.jpg',
  Citta varchar(50) DEFAULT NULL,
  Via varchar(50) DEFAULT NULL,
  Civico smallint DEFAULT NULL,
  PRIMARY KEY (Piva)
);

CREATE TABLE IF NOT EXISTS SUPERMERCATO_PRODOTTO (
  Piva char(11) NOT NULL,
  Ean char(13) NOT NULL,
  Prezzo float DEFAULT NULL,
  Numero char(1) DEFAULT NULL,
  PRIMARY KEY (Piva,Ean),
  KEY Ean (Ean),
  KEY Piva (Piva,Numero)
);

CREATE TABLE IF NOT EXISTS UTENTE (
  Email varchar(50) NOT NULL,
  `Password` varchar(12) NOT NULL,
  Nome varchar(20) DEFAULT NULL,
  Cognome varchar(30) DEFAULT NULL,
  Sesso char(6) DEFAULT NULL,
  Data_Nascita date DEFAULT NULL,
  PRIMARY KEY (Email)
);

CREATE TABLE IF NOT EXISTS VOLANTINO (
  Data_vol date NOT NULL,
  Piva char(11) NOT NULL,
  Immagine varchar(50) DEFAULT 'nondisponibile.jpg',
  PRIMARY KEY (Data_vol,Piva),
  KEY Piva (Piva)
);

CREATE TABLE IF NOT EXISTS SUPERMERCATO(
Piva CHAR(11) PRIMARY KEY,
Nome VARCHAR(100),
Mappa VARCHAR(50),
Immagine VARCHAR(50),
Citta VARCHAR(50),
Via VARCHAR(50),
Civico SMALLINT);

CREATE TABLE IF NOT EXISTS VOLANTINO(
Data_vol DATE,
Piva CHAR(11),
Immagine VARCHAR(50),
PRIMARY KEY(Data_vol,Piva),
FOREIGN KEY(Piva) REFERENCES SUPERMERCATO(Piva) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS NODO(
Numero CHAR(1),
Piva CHAR(11),
X FLOAT,
Y FLOAT,
PRIMARY KEY(Numero,Piva),
FOREIGN KEY(Piva) REFERENCES SUPERMERCATO(Piva) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS PRODOTTO(
Ean char(13) PRIMARY KEY,
Nome VARCHAR(100),
Descrizione VARCHAR(300),
Marchio VARCHAR(50),
Categoria VARCHAR(50),
Immagine VARCHAR(50)
);
CREATE TABLE IF NOT EXISTS SUPERMERCATO_PRODOTTO(
Piva CHAR(11),
Ean CHAR(13),
Prezzo FLOAT,
Numero CHAR(1),
PRIMARY KEY(Piva,Ean),
FOREIGN KEY(Ean) REFERENCES PRODOTTO(Ean) ON DELETE CASCADE,
FOREIGN KEY(Piva,Numero) REFERENCES NODO(Piva,Numero)
);
CREATE TABLE IF NOT EXISTS UTENTE(
Email VARCHAR(50) PRIMARY KEY,
Password VARCHAR(12) NOT NULL,     
Nome VARCHAR(20),
Cognome VARCHAR(30),
Sesso CHAR(6),
Data_Nascita DATE
);
CREATE TABLE IF NOT EXISTS CARRELLO(
Id_carrello INT PRIMARY KEY,
Nome VARCHAR(20)
);
CREATE TABLE IF NOT EXISTS CARRELLO_UTENTE(
Id_carrello INT,
Email VARCHAR(50),
PRIMARY KEY(Id_carrello, Email),
FOREIGN KEY(Id_carrello) REFERENCES CARRELLO(Id_carrello) ON DELETE CASCADE,
FOREIGN KEY(Email) REFERENCES UTENTE(Email) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS CARRELLO_PRODOTTI(
Id_carrello INT,
Piva CHAR(11),
Ean CHAR(13),
PRIMARY KEY(Id_carrello,Piva,Ean),
FOREIGN KEY(Id_carrello) REFERENCES CARRELLO(Id_carrello) ON DELETE CASCADE,
FOREIGN KEY(Piva) REFERENCES SUPERMERCATO(Piva) ON DELETE CASCADE,
FOREIGN KEY(Ean) REFERENCES PRODOTTO(Ean) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS LISTA(
Id_lista INT PRIMARY KEY,
Nome VARCHAR(20)
);
CREATE TABLE IF NOT EXISTS LISTA_UTENTE(
Id_lista INT,
Email VARCHAR(50),
PRIMARY KEY(Id_lista, Email),
FOREIGN KEY(Id_lista) REFERENCES LISTA(Id_lista) ON DELETE CASCADE,
FOREIGN KEY(Email) REFERENCES UTENTE(Email) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS LISTA_PRODOTTI(
Id_lista INT,
Ean CHAR(13),
PRIMARY KEY(Id_lista,Ean),
FOREIGN KEY(Id_lista) REFERENCES LISTA(Id_lista) ON DELETE CASCADE,
FOREIGN KEY(Ean) REFERENCES PRODOTTO(Ean) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS credenziali (
  email varchar(50) NOT NULL,
  password varchar(20) NOT NULL,
  resta_collegato tinyint(1) NOT NULL
);