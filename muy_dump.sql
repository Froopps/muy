CREATE DATABASE muy;
USE muy;

CREATE TABLE utente(
    email VARCHAR(200)NOT NULL,
    passwd VARCHAR(200)NOT NULL,
    nickname VARCHAR(200)DEFAULT'User'NOT NULL,
    foto VARCHAR(200)DEFAULT'defaults/default-profile-pic.png'NOT NULL,
    nome VARCHAR(200)NOT NULL,
    cognome VARCHAR(200)NOT NULL,
    dataNascita DATE NOT NULL,
    sesso ENUM('Maschio','Femmina'),
    citta VARCHAR(200),
    visibilita INT UNSIGNED NOT NULL,
    CONSTRAINT utente_pk PRIMARY KEY(email)
);
/*stato=NULL if pending*/
CREATE TABLE amicizia(
    sender VARCHAR(200)NOT NULL,
    receiver VARCHAR(200)NOT NULL,
    stato ENUM('a','r','p'),
    dataRisposta DATE,
    CONSTRAINT amicizia_pk PRIMARY KEY(sender,receiver),
    CONSTRAINT sender_fk FOREIGN KEY(sender) REFERENCES utente(email) ON UPDATE CASCADE ON DELETE NO ACTION,
    CONSTRAINT receiver_fk FOREIGN KEY(receiver) REFERENCES utente(email) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE canale(
    nome VARCHAR(200)NOT NULL,
    proprietario VARCHAR(200),
    visibilita ENUM('public','private','social')DEFAULT'public'NOT NULL,
    etichetta VARCHAR(200),
    dataCreazione DATE NOT NULL,
    dataUltimoInserimento DATE,
    CONSTRAINT canale_pk PRIMARY KEY (nome,proprietario),
    CONSTRAINT canale_fk FOREIGN KEY (proprietario) REFERENCES utente(email) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE oggettoMultimediale(
    percorso VARCHAR(200)NOT NULL,
    anteprima VARCHAR(200)DEFAULT'defaults/obj_logo.jpg'NOT NULL,
    titolo VARCHAR(200)NOT NULL,
    descrizione MEDIUMTEXT,
    tipo ENUM('v','a','i')NOT NULL,
    /*collocazione ENUM('locale','youtube')NOT NULL,*/
    dataCaricamento DATETIME NOT NULL,
    visualizzazioni BIGINT UNSIGNED DEFAULT 0 NOT NULL,
    canale VARCHAR(200)NOT NULL,
    proprietario VARCHAR(200)NOT NULL,
    CONSTRAINT oggettoMultimediale_pk PRIMARY KEY (percorso),
    CONSTRAINT oggettoMultimediale_fk FOREIGN KEY (canale,proprietario) REFERENCES canale(nome,proprietario) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE valutazione(
    utente VARCHAR(200)NOT NULL,
    relativoA VARCHAR(200)NOT NULL,
    voto ENUM('0','1','2','3','4','5')NOT NULL,
    CONSTRAINT valutazione_pk PRIMARY KEY(utente,relativoA),
    CONSTRAINT valutazione_utente_fk FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT valutazione_contenuto_kf FOREIGN KEY (relativoA) REFERENCES oggettoMultimediale(percorso) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE commento(
    id BIGINT NOT NULL,
    utente VARCHAR(200)NOT NULL,
    contenuto VARCHAR(200)NOT NULL,
    testo MEDIUMTEXT NOT NULL,
    dataRilascio DATE NOT NULL,
    ora TIME NOT NULL,
    CONSTRAINT commento_pk PRIMARY KEY(id,contenuto),
    CONSTRAINT commento_contenuto_fk FOREIGN KEY (contenuto) REFERENCES oggettoMultimediale(percorso) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT commento_utente_fk FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE CASCADE ON DELETE CASCADE
);

/*In order to add some attributes in the future*/
CREATE TABLE categoria(
    tag VARCHAR(200)NOT NULL,
    CONSTRAINT categoria_pk PRIMARY KEY(tag)
);

CREATE TABLE contenutoTaggato(
    tag VARCHAR(200)NOT NULL,
    oggetto VARCHAR(200)NOT NULL,
    CONSTRAINT categoria_pk PRIMARY KEY(tag,oggetto),
    CONSTRAINT oggetto_fk FOREIGN KEY (oggetto) REFERENCES oggettoMultimediale(percorso) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT categoria_fk FOREIGN KEY (tag) REFERENCES categoria(tag) ON UPDATE CASCADE ON DELETE CASCADE
);