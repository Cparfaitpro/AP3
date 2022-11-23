<link href="/public/home.css" rel="stylesheet"/>

<div v-scope v-cloak class="d-flex flex-column justify-content-center align-items-center bannerHome">
    <h1>Bienvenue sur Hackat'innov 👋</h1>
    <div class="col-12 col-md-9 d-flex">
        <img src="<?= $hackathon['affiche'] ?>" class="affiche d-md-block d-none" alt="Affiche de l'évènement.">
        <div class="px-5" v-if="!participantsIsShown">
            <h2><?= $hackathon['thematique'] ?></h2>
            <p><?= nl2br($hackathon['objectifs']) ?></p>
            <p><?= nl2br($hackathon['conditions']) ?></p>

            <div class="card">
                <div>Informations :</div>
                <div><em>Date :</em> <?= date_create($hackathon['dateheuredebuth'])->format("d/m/Y H:i") ?>
                    au <?= date_create($hackathon['dateheurefinh'])->format("d/m/Y H:i") ?></div>
                <div><em>Lieu :</em> <?= $hackathon['ville'] ?></div>
                <div><em>Organisateur :</em> <?= "{$organisateur['nom']} {$organisateur['prenom']}" ?></div>
            </div>
            <div id="participantButton" class="d-flex flex-wrap pt-5">
            <?php if ($checkParticipation) { ?>
                <a class="btn bg-green m-2 button-home" href="/join?idh=<?= $hackathon["idhackathon"] ?>">Rejoindre</a>
                <a class="btn bg-green m-2 button-home" href="/create-team?idh=<?= $hackathon["idhackathon"] ?>">Créer mon équipe</a>
                <?php } ?>
                <a class="btn bg-green m-2 button-home" href="#" @click.prevent="getParticipants">
                    <span v-if="!loading">Les participants</span>
                    <span v-else>Chargement en cours…</span>
                </a>
            </div>
        </div>
        <div v-else>
            <a class="btn bg-green m-2 button-home" href="#" @click.prevent="participantsIsShown = false">←</a> Listes des participants

            <ul class="pt-3">
                <li class="member" v-for="p in participants">🧑‍💻 {{p['nomequipe']}} <a class="btn btn-sm btn-primary" v-bind:href="'/membre?idh=' + p['idequipe']">
                                Les membres
                            </a> </li>
            </ul>

        </div>
    </div>
</div>

<!-- Petite Vue, version minimal de VueJS, voir https://github.com/vuejs/petite-vue -->
<!-- v-scope, @click, v-if, v-else, v-for : sont des éléments propre à VueJS -->
<!-- Pour plus d'informations, me demander ou voir la documentation -->
<script type="module">
    import {createApp} from 'https://unpkg.com/petite-vue?module'

    createApp({
        participants: [],
        participantsIsShown: false,
        loading: false,
        getParticipants() {
            if (this.participants.length > 0) {
                // Si nous avons déjà chargé les participants, alors on utilise la liste déjà obtenue.
                this.participantsIsShown = true
            } else {
                this.loading = true;

                // Sinon on charge via l'API la liste des participants
                fetch("/api/hackathon/<?= $hackathon['idhackathon'] ?>/equipe")
                    .then(result => result.json()) // Transforme le retour de l'API en tableau de participants
                    .then(participants => this.participants = participants) // Sauvegarde la liste.
                    .then(() => this.participantsIsShown = true) // Affiche la liste
                    .then(() => this.loading = false) // Arrêt de l'état chargement
            }
        }
    }).mount()
</script>