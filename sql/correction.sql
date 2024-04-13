-- Requête 1
SELECT
    pseudo,
    COUNT(contenus.id) AS nb_contenus
FROM
    utilisateurs
    LEFT JOIN contenus ON contenus.id_utilisateur = utilisateurs.id
GROUP BY
    utilisateurs.pseudo
ORDER BY
    nb_contenus DESC
LIMIT
    0, 3;

-- Requête 2
SELECT
    contenus.id,
    contenus.chemin_image,
    utilisateurs.pseudo,
    likes_par_contenu.nb_likes,
    commentaires_par_contenu.nb_commentaires
FROM
    contenus
    LEFT JOIN utilisateurs ON utilisateurs.id = contenus.id_utilisateur
    LEFT JOIN (
        SELECT
            id_contenu,
            COUNT(id_utilisateur) AS nb_likes
        FROM
            likes
        GROUP BY
            id_contenu
    ) AS likes_par_contenu ON likes_par_contenu.id_contenu = contenus.id
    LEFT JOIN (
        SELECT
            id_contenu,
            COUNT(id) AS nb_commentaires
        FROM
            commentaires
        GROUP BY
            id_contenu
    ) AS commentaires_par_contenu ON commentaires_par_contenu.id_contenu = contenus.id;

-- Requête 3
SELECT
    contenus.id,
    contenus.chemin_image,
    contenus.description,
    COUNT(likes.id_utilisateur) AS nb_likes
FROM
    contenus
    LEFT JOIN likes ON likes.id_contenu = contenus.id
GROUP BY
    contenus.id,
    contenus.chemin_image,
    contenus.description
ORDER BY
    nb_likes DESC
LIMIT
    0, 3;

-- Requête 4
SELECT
    contenus.id,
    contenus.chemin_image,
    contenus.description,
    COUNT(commentaires.id) AS nb_commentaires
FROM
    contenus
    LEFT JOIN commentaires ON commentaires.id_contenu = contenus.id
GROUP BY
    contenus.id,
    contenus.chemin_image,
    contenus.description
ORDER BY
    nb_commentaires DESC
LIMIT
    0, 3;

-- Requête 5
SELECT
    DATE_FORMAT(commentaires.date_publication, '%Y-%m-%d') AS jour,
    COUNT(commentaires.id) AS nb_commentaires
FROM
    commentaires
GROUP BY
    jour;

-- Requête 6
SELECT
    *
FROM
    contenus
WHERE
    NOT EXISTS (
        SELECT
            *
        FROM
            commentaires
        WHERE
            id_contenu = contenus.id
    );

-- Requête 7
SELECT
    *
FROM
    utilisateurs
WHERE
    NOT EXISTS (
        SELECT
            *
        FROM
            commentaires
        WHERE
            commentaires.id_utilisateur = utilisateurs.id
    )
    AND NOT EXISTS (
        SELECT
            *
        FROM
            likes
        WHERE
            likes.id_utilisateur = utilisateurs.id
    );

-- Requête 8
SELECT
    jours.jour,
    COALESCE(nb_publications, 0) AS nb_publications,
    COALESCE(nb_commentaires, 0) AS nb_commentaires
FROM ( SELECT DISTINCT
        tous_jours.jour
    FROM (( SELECT DISTINCT
                DATE_FORMAT(date_publication, "%Y-%m-%d") AS jour
            FROM
                contenus)
        UNION ( SELECT DISTINCT
                DATE_FORMAT(date_publication, "%Y-%m-%d") AS jour
            FROM
                commentaires)) AS tous_jours) AS jours
    LEFT JOIN (
        SELECT
            DATE_FORMAT(commentaires.date_publication, '%Y-%m-%d') AS jour,
            COUNT(commentaires.id) AS nb_commentaires
        FROM
            commentaires
        GROUP BY
            jour) AS commentaires_par_jour ON commentaires_par_jour.jour = jours.jour
    LEFT JOIN (
        SELECT
            DATE_FORMAT(contenus.date_publication, '%Y-%m-%d') AS jour,
            COUNT(contenus.id) AS nb_publications
        FROM
            contenus
        GROUP BY
            jour) AS contenus_par_jour ON contenus_par_jour.jour = jours.jour
ORDER BY
    nb_publications DESC,
    nb_commentaires DESC;

-- Requête 9
SELECT
    contenus.id,
    contenus.chemin_image,
    utilisateurs.pseudo,
    likes_par_contenu.nb_likes,
    commentaires_par_contenu.nb_commentaires
FROM
    contenus
    LEFT JOIN utilisateurs ON utilisateurs.id = contenus.id_utilisateur
    LEFT JOIN (
        SELECT
            id_contenu,
            COUNT(id_utilisateur) AS nb_likes
        FROM
            likes
        GROUP BY
            id_contenu
    ) AS likes_par_contenu ON likes_par_contenu.id_contenu = contenus.id
    LEFT JOIN (
        SELECT
            id_contenu,
            COUNT(id) AS nb_commentaires
        FROM
            commentaires
        GROUP BY
            id_contenu
    ) AS commentaires_par_contenu ON commentaires_par_contenu.id_contenu = contenus.id
WHERE
    nb_commentaires >= 5
    AND nb_likes >= 10;

-- Requête 10
SELECT
    *
FROM
    utilisateurs
WHERE
    EXISTS (
        SELECT
            *
        FROM
            contenus
        WHERE
            id_utilisateur = utilisateurs.id
            AND TIMESTAMPDIFF(
                MINUTE,
                utilisateurs.date_inscription,
                contenus.date_publication
            ) <= 5
    )