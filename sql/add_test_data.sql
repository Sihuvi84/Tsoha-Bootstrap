-- Rooli-taulun testidata
INSERT INTO Rooli (r_nimi) VALUES ('Ylläpitäjä'); 
INSERT INTO Rooli (r_nimi) VALUES ('Peruskäyttäjä'); 

-- Kayttaja-taulun testidata
INSERT INTO Kayttaja (k_nimi, k_salasana, kr_tunnus) VALUES ('Saunatonttu', '!1lpKTCe/Rqek', 1); 
INSERT INTO Kayttaja (k_nimi, k_salasana, kr_tunnus) VALUES ('Kalle', '!1lpKTCe/Rqek', 2); 

-- Luokka-taulun testidata
INSERT INTO Luokka (l_nimi, l_kuvaus, lk_tunnus) VALUES ('Pihatyöt', 'Haravointi, lumityöt, rikkaruohojen kitkeminen...', 1); 
INSERT INTO Luokka (l_nimi, l_kuvaus, lk_tunnus) VALUES ('Lemmikit', 'Ulkoilutus, ruuan antaminen, harjaus, rapsuttelu, leikkiminen..', 1); 
INSERT INTO Luokka (l_nimi, l_kuvaus, lk_tunnus) VALUES ('Siivous', 'Tiskaus, imurointi, ikkunoiden peseminen,...', 2); 
INSERT INTO Luokka (l_nimi, l_kuvaus, lk_tunnus) VALUES ('Kissa', 'Kissan hoitoon liittyvät tehtävät', 2); 
INSERT INTO Luokka (l_nimi, l_kuvaus, lk_tunnus) VALUES ('Koira', 'Koiran hoitoon liittyvät tehtävät', 1); 

--Askare-taulun testidata
INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Tiskaus', 'Jokapäiväinen paha velvollisuus.', 5, 1, null, NOW(), NOW()+ interval '24 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Imurointi', 'Asunnon imurointi', 4, 7, null, NOW(), NOW()+ interval '168 hours', 2);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Koiran ulkoilutus', 'Monta kertaa päivässä!', 1, 1, null, NOW(), NOW() + interval '24 hours', 1);

INSERT INTO Askare (a_nimi, a_kuvaus, a_prioriteetti, a_toistuvuus, a_tehty, a_luotu, a_deadline, ak_kayttajatunnus)
VALUES ('Roskat', 'Ainakin biojätteet...', 3, 1, null, NOW(), NOW()+ interval '24 hours', 1);

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