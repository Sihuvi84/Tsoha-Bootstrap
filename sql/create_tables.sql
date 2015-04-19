
CREATE TABLE Rooli(
  r_tunnus SERIAL PRIMARY KEY, 
  r_nimi varchar(100) NOT NULL
);

CREATE TABLE Kayttaja(
  k_tunnus SERIAL PRIMARY KEY,
  k_nimi varchar(100) NOT NULL UNIQUE, 
  k_salasana varchar(100) NOT NULL,
  kr_tunnus INTEGER REFERENCES Rooli(r_tunnus)
);

CREATE TABLE Luokka(
  l_tunnus SERIAL PRIMARY KEY, 
  l_nimi varchar(100) NOT NULL, 
  l_kuvaus text,
  lk_tunnus INTEGER REFERENCES Kayttaja(k_tunnus)
);

CREATE TABLE Askare(
  a_tunnus SERIAL PRIMARY KEY, 
  a_nimi varchar(100) NOT NULL, 
  a_kuvaus text,
  a_prioriteetti SMALLINT NOT NULL,
  a_toistuvuus SMALLINT,
  a_tehty TIMESTAMP,
  a_luotu TIMESTAMP NOT NULL,
  a_deadline TIMESTAMP,
  ak_kayttajatunnus INTEGER REFERENCES Kayttaja(k_tunnus)
);

CREATE TABLE Askareluokka(
  aa_tunnus INTEGER REFERENCES Askare(a_tunnus), 
  al_tunnus INTEGER REFERENCES Luokka(l_tunnus),
  PRIMARY KEY(aa_tunnus, al_tunnus)
);