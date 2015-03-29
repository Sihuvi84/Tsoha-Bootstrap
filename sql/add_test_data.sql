-- Rooli-taulun testidata
INSERT INTO Rooli (r_nimi) VALUES ('Ylläpitäjä'); 
INSERT INTO Rooli (r_nimi) VALUES ('Peruskäyttäjä'); 

-- Kayttaja-taulun testidata
INSERT INTO Kayttaja (k_tunnus, k_nimi, k_salasana, kr_tunnus) VALUES ('Saunatonttu', 'Suvi', 'eivielasalattuna', 1); 
INSERT INTO Kayttaja (k_tunnus, k_nimi, k_salasana, kr_tunnus) VALUES ('Kalle', 'Kalle Peruskäyttäjä', 'eivielasalattuna', 2); 

-- Luokka-taulun testidata
INSERT INTO Luokka (l_nimi, l_kuvaus) VALUES ('Pihatyöt', 'Haravointi, lumityöt, rikkaruohojen kitkeminen...'); 
INSERT INTO Luokka (l_nimi, l_kuvaus) VALUES ('Lemmikit', 'Ulkoilutus, ruuan antaminen, harjaus, rapsuttelu, leikkiminen..'); 
INSERT INTO Luokka (l_nimi, l_kuvaus) VALUES ('Siivous', 'Tiskaus, imurointi, ikkunoiden peseminen,...'); 
INSERT INTO Luokka (l_nimi, l_kuvaus) VALUES ('Kissa', 'Kissan hoitoon liittyvät tehtävät'); 
INSERT INTO Luokka (l_nimi, l_kuvaus) VALUES ('Koira', 'Koiran hoitoon liittyvät tehtävät'); 

--Askare-taulun testidata
INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Tiskaus', 'Jokapäiväinen paha velvollisuus.', 5, 1, null, NOW(), NOW()+ interval '24 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Imurointi', 'Asunnon imurointi', 4, 7, null, NOW(), NOW()+ interval '168 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Koiran ulkoilutus', 'Monta kertaa päivässä!', 1, 1, null, NOW(), NOW() + interval '24 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Roskat', 'Ainakin biojätteet...', 3, 1, null, NOW(), NOW()+ interval '24 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Kissan harjaus', 'Kissa haluaa lempeää harjausta. Suoritettava kissan ehdoilla. Mau. ', 1, 1, null, NOW(), NOW()+ interval '24 hours', 1);


-- Askareluokka-taulun testidata
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (1, 3); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (2, 3); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (3, 2); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (4, 3); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (5, 2); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (3, 5); 
INSERT INTO Askareluokka (aa_tunnus, al_tunnus) VALUES (5, 4); 