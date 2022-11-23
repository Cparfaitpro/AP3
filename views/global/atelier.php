<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg fullContainer">
<div class="card cardRadius">
        <div class="card-body">
            <h3>Atelier : <?= $atelier['nom_atelier'] ?></h2>
            <p>Salle : <?= $salle['nom_salle'] ?> </p>
            <p>Liste des conférenciers : </p>
            <?php foreach ($conferencier as $conference) { ?>
                <p>- <?=$conference['nom']?> <?=$conference['prenom']?>
            <?php } ?>
            <p>Dans le cadre de la thématique : <?= $hackathonAtelier['thematique'] ?></p>
            <p>Début : <?= $atelier['datejourdebut'] ?> à <?= $atelier["heuredebut"] ?></p>
            <p>Fin : <?= $atelier['datejourfin'] ?> à <?= $atelier["heurefin"] ?></p>
            <p>Nombre de place pour l'évenement : <?= $atelier["NbPlace"] ?> Place(s)</p>
        </div>
    </div>
</div>